<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Point;

class PointTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGettersAndSetters()
    {
		$point = new Point(2,3);
		$this->assertEquals(2, $point->getX());
		$this->assertEquals(3, $point->getY());
		
		$point->setX(4);
		$point->setY(1);		
		$this->assertEquals(4, $point->getX());
		$this->assertEquals(1, $point->getY());
		
		$point->moveX(1);
		$point->moveY(2);
		$this->assertEquals(5, $point->getX());
		$this->assertEquals(3, $point->getY());
    }
	
	public function testMovePoint()
    {
		$point = new Point(6,4);		
		$point->moveX(-1);
		$point->moveY(1);
		$this->assertEquals(5, $point->getX());
		$this->assertEquals(5, $point->getY());
    }
}
