<?php
namespace ProtectQueen;

require_once 'Point.php';
require_once 'Person.php';
require_once 'Kingdom.php';
require_once 'CustomException.php';
use ProtectQueen\Point;
use ProtectQueen\Person;
use ProtectQueen\Kingdom;
use ProtectQueen\InvalidFaceException;
use ProtectQueen\InvalidDirectionException;

try{
	//$p = new Point(9,5);
	//print_r($p->getY());
	//$p->moveY(3);
	//print_r($p->getY());
	//$queen = new Person($p);
	//print_r($queen->getposition()->getY());
	$kingdom = new Kingdom(5,5);
	//$kingdom->move();
	$kingdom->place(2,4,'WESTA');
	$kingdom->move();
	$kingdom->rotate('LEFT');
	$kingdom->move();
	$kingdom->move();
	$kingdom->rotate('RIGHT');
	$kingdom->move();
	$kingdom->rotate('RIGHT');
	//$kingdom->rotate('LEFT');
	//$kingdom->rotate('LEFT');
	//$kingdom->place(5,3,'NORTH');
	$kingdom->move();
	//$kingdom->move();
	//$kingdom->rotate('LEFT');
	print_r($kingdom->getQueen()->getposition()->getX());
	print_r($kingdom->getQueen()->getposition()->getY());
	print_r($kingdom->getQueen()->getface());
}catch(InvalidDirectionException $e){
	echo $e->getMessage();
}catch(InvalidFaceException $e){
	echo $e->getMessage();
}catch(InvalidObjectException $e){
	echo $e->getMessage();
}


?>