<?php
namespace App;

class Person{
	/**
	* @var Postion
	*/
	private $_position;	
	/**
	* @var string
	*/
	private $_face;
	/**
	* @var array
	*/
	private $_allowed_faces = ["NORTH","EAST","SOUTH","WEST"];
	/**
	* @var array
	*/
	private $_allowed_rotate_directions = ['LEFT', 'RIGHT'];
	
	public function __construct(Point $p, string $face) {
		$this->_position = $p;
		if(!in_array($face,$this->_allowed_faces)){
			throw new InvalidFaceException("Invalid Face value");
		}
		$this->_face = $face;
    }
	
	/**     
	 * Set new face value
     *
     * @return void
     */
	public function setFace($val){
		//$allowed_values = ['NORTH', 'SOUTH', 'WEST', 'EAST'];
		if(!in_array($val,$this->_allowed_faces)){
			throw new InvalidFaceException("Invalid Face value");
		}
		$this->_face = $val;
	}
	public function getposition(){
		return $this->_position;
	}
	/**     
     *
     * @return string
     */
	public function getFace(){
		return $this->_face;
	}
	
	/**     
     *
     * @return array
     */
	public function getAllowedFaces(){
		return $this->_allowed_faces;
	}
	
	/**     
     *
     * @return array
     */
	public function getAllowedDirections(){
		return $this->_allowed_rotate_directions;
	}
}