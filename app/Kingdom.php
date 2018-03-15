<?php
namespace App;

//use ProtectQueen\Person;
//use ProtectQueen\Point;

class Kingdom{
	/**
	* @var Person
	*/
	private $_queen;
	/**
	* @var int
	*/
	private $_width;
	/**
	* @var int
	*/
	private $_height;
	
	public function __construct($width = 2, $height = 2) {
		if(($width >1 && $height>1) && ($width <10 && $height<10)){
			$this->_width = $width;
			$this->_height = $height;
		}else{
			throw new InvalidDimensionException("Invalid Dimension");
		}
    }
	
	/**     
	 * Put the Queen to the Kingdom     
     * @return void
     */
	public function addQueen(Person $queen){
		if($queen->getPosition()->getX()<= $this->_width && $queen->getPosition()->getY()<= $this->_height){
			$this->_queen = $queen;
		}else{
			throw new InvalidMoveException("Invalid move");
		}
	}
	public function getQueen(){
		return $this->_queen;
	}
	public function getWidth(){
		return $this->_width;
	}
	public function getHeight(){
		return $this->_height;
	}
	
	/**     
	 * Put the Queen on a given place inside the Kingdom
     * @param int x
	 * @param int y
	 * @param string face
     * @return true|throw Exception
     */
	public function place($x,$y,$face){
		try{
			if($this->isMoveValid($x,$y)){
				if($this->_queen){
					$this->_queen->getPosition()->setX($x);
					$this->_queen->getPosition()->setY($y);
					$this->_queen->setFace($face);
				}else{
					$point = new Point($x, $y);
					$queen = new Person($point,$face);					
					$this->addQueen($queen);
				}
				return true;
			}else{
				throw new InvalidMoveException("Invalid move");
			}
		}catch(Exception $e){
			echo $e->getMessage();
			exit();
		}		
	}
	
	/**     
	 * Move the Queen one unit on the direction she is actually facing
     *
     * @return true|throw Exception
     */
	public function move(){
		try{
			if(!$this->_queen){
				throw new InvalidObjectException("QUEEN MISSING");
			}		
			if($this->_queen->getFace() == "SOUTH"){
				if($this->isMoveValid(0,-1)){
					$this->_queen->getposition()->moveY(-1);
				}else{
					throw new InvalidMoveException("Invalid move");
				}
			}
			if($this->_queen->getFace() == "NORTH"){
				if($this->isMoveValid(0,1)){
					$this->_queen->getposition()->moveY(1);
				}else{
					throw new InvalidMoveException("Invalid move");
				}
			}		
			if($this->_queen->getFace() == "EAST"){
				if($this->isMoveValid(1,0)){
					$this->_queen->getposition()->moveX(1);
				}else{
					throw new InvalidMoveException("Invalid move");
				}	
			}
			if($this->_queen->getFace() == "WEST"){
				if($this->isMoveValid(-1,0)){
					$this->_queen->getposition()->moveX(-1);
				}else{
					throw new InvalidMoveException("Invalid move");
				}	
			}
			return true;
		}catch(Exception $e){
			echo $e->getMessage();
			exit();
		}		
	}
	
	/**     
	 * Rotate the queen 90 degrees left or right
     * @param string direction	 
     * @return string|throw Exception
     */
	public function rotate($direction){
		try{
			$allowed_directions = $this->_queen->getAllowedDirections();
			if(!in_array($direction,$allowed_directions)){
				throw new InvalidDirectionException("Invalid rotation direction");
			}
			$faces = $this->_queen->getAllowedFaces();
			$position = array_search($this->_queen->getFace(), $faces, true);
			if($direction == "LEFT"){
				($position != 0)?$this->_queen->setFace($faces[$position-1]):$this->_queen->setFace($faces[count($faces)-1]);			
			}else{		
				($position != count($faces)-1)?$this->_queen->setFace($faces[$position+1]):$this->_queen->setFace($faces[0]);
			}
			return $this->_queen->getFace();
		}catch(Exception $e){
			echo $e->getMessage();
			exit();
		}				
	}
	
	/**     
	 * Check if the Queen move is valid     
	 * @param int x
	 * @param int y
     * @return true|false
     */
	public function isMoveValid($x,$y){
		try{			
			if($this->_queen){
				return (($this->_queen->getposition()->getX()+ $x <= $this->_width) && ($this->_queen->getposition()->getX()+ $x >= 0)) && (($this->_queen->getposition()->getY()+$y <= $this->_height) && ($this->_queen->getposition()->getY()+$y >= 0)); 
			}else{
				return ($x <= $this->_width && $x >= 0) && ($y <= $this->_height && $y >= 0); 
			}
		}catch(Exception $e){
			echo $e->getMessage();
			exit();
		}		
	}
	
	/**     
	 * Format the Output
     *
     * @return string
     */
	public function output(){
		try{
			if(!$this->_queen){
				throw new InvalidObjectException("QUEEN MISSING");
			}
			return $this->__toString();
		}catch(Exception $e){
			echo $e->getMessage();
			exit();
		}		
	}
	
	public function __toString(){
		try{			
			return $this->_queen->getposition()->getX().', '.$this->_queen->getposition()->getY().', '.$this->_queen->getFace();
		}catch(Exception $e){
			echo $e->getMessage();
			exit();
		}		
	}
}