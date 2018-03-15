<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Util\LogRepository as LogRepo;
use Validator;
use File;
use App\{Person, Kingdom, Point, InvalidFaceException, InvalidDimensionException, InvalidMoveException,InvalidObjectException,InvalidDirectionException };

class KingdomController extends Controller
{
    public function __construct() {
        //$this->middleware('jwt.auth', ['except' => ['createKindom']]);
    }    

    /**
     * Creating a new kingdom
     *
     * @return \Illuminate\Http\Response
     */
    public function createKingdom(Request $request)
    {
        try{
            //var_dump($request->input());die();
			$data = $request->input();			
			if (!is_array($data)) {
				$result = array("code" => 400, "description" => "invalid request body");
				return response()->json($result, 400);
			}
			//validation of data
			$validator = Validator::make($request->all(), [
				'width'     => 'required|numeric|min:2|max:9',
				'length'	=> 'required|numeric|min:2|max:9',				
			]);
			if ($validator->fails()) {
				return response()->json(
					[
						"code"		=> 422,
						'errors' 	=> $validator->messages(),
					], 
					422
				);
			}						
			$kingdom = new Kingdom($data['width'], $data['length']);			
			
			//create file to store data to use later
			$file_name = 'kingdom.txt';
			$this->saveFile($file_name,serialize($kingdom));
			$result = [
				"code" 		=> 201,
				"message" 	=> "Kingdom has been successfully created",				
			];
			return response()->json($result, 201);
        } catch (InvalidDimensionException $e) {
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
            return response()->json(
				[
					"code"		=> 400,
					'message' 	=> $e->getMessage(),
				], 
				400
			);
        }catch (Exception $ex) {
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
            return response()->json(
				[
					"code"		=> 500,
					'message' 	=> "An internal server error occurred",
				], 
				500
			);
        }         
    }

	
	/**
     * Creating a new Queen
     *
     * @return \Illuminate\Http\Response
     */
    public function createQueen(Request $request)
    {
        try{            
			$data = $request->input();
			if (!is_array($data)) {
				$result = array("code" => 400, "description" => "invalid request body");
				return response()->json($result, 400);
			}
			//validation of data
			$validator = Validator::make($request->all(), [
				'x'     => 'required|numeric|min:0',
				'y'		=> 'required|numeric|min:0',
				'face'	=> 'required|string|in:WEST,NORTH,EAST,SOUTH',
			]);
			if ($validator->fails()) {
				return response()->json(
					[
						"code"		=> 422,
						'errors' 	=> $validator->messages(),
					], 
					422
				);
			}
			$point = new Point($data['x'], $data['y']);
			$queen = new Person($point, $data['face']);

			//create file to store data to use later
			$file_name = 'queen.txt';
			//File::put(public_path($file_name),serialize($queen));
			$this->saveFile($file_name,serialize($queen));
			$result = [
				"code" 		=> 201,
				"message" 	=> "Queen has been successfully created",
			];
			return response()->json($result, 201);
        } catch (InvalidFaceException $e) {
            return response()->json(
				[
					"code"		=> 400,
					"message" 	=> $e->getMessage(),					
				], 
				400
			);
        } catch (Exception $e) {
            LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
			return response()->json(
				[
					"code"		=> 500,
					'message' 	=> "An internal server error occurred",
				], 
				500
			);
        }       
    }
    /**
     * Move the Queen inside the Kingdom.
     *     
     * @return \Illuminate\Http\Response
     */
    public function moveQueen()
    {
        try{
			$kingdom_file_name = 'kingdom.txt';			
			$kingdom = null;			
			if(File::exists(public_path($kingdom_file_name))){
				$kingdom = File::get(public_path($kingdom_file_name));
			}
			
			if($kingdom){
				$kingdom = unserialize($kingdom);
				$kingdom->move();				
				$this->saveFile($kingdom_file_name,serialize($kingdom));
				$result = [
					"code" 		=> 200,
					"message" 	=> "The move action was successfully done !",
				];
				return $result;
			}else{
				return response()->json(
					[
						"code"		=> 404,
						'message' 	=> "Kingdom not found",
					], 
					404
				);
			}
		}catch (InvalidMoveException $e) {
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
            return response()->json(
				[
					"code"		=> 400,
					'message' 	=> $e->getMessage(),
				], 
				400
			);
        }catch (InvalidObjectException $e) {
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
            return response()->json(
				[
					"code"		=> 400,
					'message' 	=> $e->getMessage(),
				], 
				400
			);
        }catch(Exception $e){
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
			return response()->json(
				[
					"code"		=> 500,
					'message' 	=> "An internal server error occurred",
				], 
				500
			);
		}
    }

	/**
     * Creating a new Queen
     *
     * @return \Illuminate\Http\Response
     */
    public function placeQueen(Request $request)
    {
        try{            
			$data = $request->input();
			if (!is_array($data)) {
				$result = array("code" => 400, "description" => "invalid request body");
				return response()->json($result, 400);
			}
			//validation of data
			$validator = Validator::make($request->all(), [
				'x'     => 'required|numeric|min:0',
				'y'		=> 'required|numeric|min:0',
				'face'	=> 'required|string|in:WEST,NORTH,EAST,SOUTH',
			]);
			if ($validator->fails()) {
				return response()->json(
					[
						"code"		=> 422,
						'errors' 	=> $validator->messages(),
					], 
					422
				);
			}
			
			$kingdom_file_name = 'kingdom.txt';			
			$kingdom = null;			
			if(File::exists(public_path($kingdom_file_name))){
				$kingdom = File::get(public_path($kingdom_file_name));
			}			
			if($kingdom){
				$kingdom = unserialize($kingdom);
				$kingdom->place($data['x'], $data['y'], $data['face']);
				$this->saveFile($kingdom_file_name,serialize($kingdom));
				$result = [
					"code" 		=> 200,
					"message" 	=> "The Queen has been successfully place in the kingdom",
				];
				return $result;
			}else{
				return response()->json(
					[
						"code"		=> 404,
						'message' 	=> "Kingdom not found",
					], 
					404
				);
			}
			return response()->json($result, 201);
        }catch (InvalidMoveException $e) {
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
            return response()->json(
				[
					"code"		=> 400,
					'message' 	=> $e->getMessage(),
				], 
				400
			);
        } catch (InvalidFaceException $e) {
            return response()->json(
				[
					"code"		=> 400,
					"message" 	=> $e->getMessage(),					
				], 
				400
			);
        } catch (Exception $e) {
            LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
			return response()->json(
				[
					"code"		=> 500,
					'message' 	=> "An internal server error occurred",
				], 
				500
			);
        }       
    }
	
	/**
     * Rotate the Queen in the given direction.
     *     
     * @return \Illuminate\Http\Response
     */
    public function rotateQueen(Request $request)
    {
        try{
			$data = $request->input();			
			if (!is_array($data)) {
				$result = array("code" => 400, "description" => "invalid request body");
				return response()->json($result, 400);
			}
			//validation of data
			$validator = Validator::make($request->all(), [
				'direction'     => 'required|in:LEFT,RIGHT',				
			]);
			if ($validator->fails()) {
				return response()->json(
					[
						"code"		=> 422,
						'errors' 	=> $validator->messages(),
					], 
					422
				);
			}
			$kingdom_file_name = 'kingdom.txt';			
			$kingdom = null;			
			if(File::exists(public_path($kingdom_file_name))){
				$kingdom = File::get(public_path($kingdom_file_name));
			}
			
			if($kingdom){
				$kingdom = unserialize($kingdom);
				$kingdom->rotate($data['direction']);
				$this->saveFile($kingdom_file_name,serialize($kingdom));
				$result = [
					"code" 		=> 200,
					"message" 	=> "The rotate action was successfully done !",
				];
				return $result;
			}else{
				return response()->json(
					[
						"code"		=> 404,
						'message' 	=> "Kingdom not found",
					], 
					404
				);
			}
		}catch (InvalidDirectionException $e) {
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
            return response()->json(
				[
					"code"		=> 400,
					'message' 	=> $e->getMessage(),
				], 
				400
			);
        }catch (InvalidObjectException $e) {
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
            return response()->json(
				[
					"code"		=> 400,
					'message' 	=> $e->getMessage(),
				], 
				400
			);
        }catch(Exception $e){
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
			return response()->json(
				[
					"code"		=> 500,
					'message' 	=> "An internal server error occurred",
				], 
				500
			);
		}
    }
	
    /**     
     *
     * @param  \Illuminate\Http\Request  $request     
     * @return \Illuminate\Http\Response
     */
    public function addQueen(Request $request)
    {
        try{
			$kingdom_file_name = 'kingdom.txt';
			$queen_file_name = 'queen.txt';
			$kingdom = null;
			$queen = null;
			if(File::exists(public_path($kingdom_file_name)) && File::exists(public_path($queen_file_name))){
				$kingdom = File::get(public_path($kingdom_file_name));
				$queen = File::get(public_path($queen_file_name));
			}
			
			if($kingdom && $queen){
				$kingdom = unserialize($kingdom);
				$queen = unserialize($queen);
				$kingdom->addQueen($queen);
				$this->saveFile($kingdom_file_name, serialize($kingdom));
				$result = [
					"code" 		=> 200,
					"message" 	=> "Queen has been successfully added to the Kingdom",				
				];
				return $result;
			}else{
				return response()->json(
					[
						"code"		=> 404,
						'message' 	=> "The Kingdom or Queen not found",
					], 
					404
				);
			}
		}catch (InvalidMoveException $e) {
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
            return response()->json(
				[
					"code"		=> 400,
					'message' 	=> $e->getMessage(),
				], 
				400
			);
        }catch(Exception $e){
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
			return response()->json(
				[
					"code"		=> 500,
					'message' 	=> "An internal server error occurred",
				], 
				500
			);
		}
    }
	
	
	/**     
     * @param $file_name string
	 * @param $data string
     * @return void
     */
	private function saveFile($file_name, $data){
		File::put(public_path($file_name),$data);
	}
	
    /**     
     *     
     * @return \Illuminate\Http\Response
     */
    public function output()
    {
        try{
			$kingdom_file_name = 'kingdom.txt';			
			$kingdom = null;			
			if(File::exists(public_path($kingdom_file_name))){
				$kingdom = File::get(public_path($kingdom_file_name));
			}
			
			if($kingdom){
				$kingdom = unserialize($kingdom);				
				$result = [
					"code" 		=> 200,
					"output" 	=> $kingdom->output(),
				];
				return $result;
			}else{
				return response()->json(
					[
						"code"		=> 404,
						'message' 	=> "Kingdom not found",
					], 
					404
				);
			}
		}catch (InvalidObjectException $e) {
			LogRepo::printLog('error', $e->getMessage()." on line .".$e->getLine());
            return response()->json(
				[
					"code"		=> 400,
					'message' 	=> $e->getMessage(),
				], 
				400
			);
        }catch(Exception $e){
			LogRepo::printLog('error', $e->getMessage()." on line .".$ex->getLine());
			return response()->json(
				[
					"code"		=> 500,
					'message' 	=> "An internal server error occurred",
				], 
				500
			);
		}
    }
}
