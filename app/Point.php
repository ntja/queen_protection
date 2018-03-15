<?php
namespace App;

class Point{
	/**
	* @var int
	*/	
	private $_x;
	/**
	* @var int
	*/
	private $_y;	
	
	public function __construct($x = 0, $y = 0) {
        $this->_x = $x;
		$this->_y = $y;
    }
	
	public function getX(){
		return $this->_x;
	}	
	public function getY(){
		return $this->_y;
	}	
	public function setX($x){
		$this->_x = $x;
	}
	public function setY($y){
		$this->_y = $y;
	}
	public function moveY($y){
		$this->_y += $y;
	}
	public function moveX($x){
		$this->_x += $x;
	}
}
