<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\{Point,Person,Kingdom,InvalidMoveException,InvalidDirectionException,InvalidFaceException, InvalidObjectException, InvalidDimensionException};

class KingdomTest extends TestCase
{
    /**
     * Test cases of Kingdom class
     *
     * @return void
     */
	
	public function testKingDomCreation()
    {
		$this->expectException(InvalidDimensionException::class);
		$this->expectExceptionMessage("Invalid Dimension");
		$kingdom = new Kingdom(8,11);
		
		$kingdom = new Kingdom(8,5);
		$this->assertEquals(8, $kingdom->getWidth());
		$this->assertEquals(5, $kingdom->getHeight());
		
        $this->expectException(InvalidDimensionException::class);
		$this->expectExceptionMessage("Invalid Dimension");
		$kingdom = new Kingdom(8,1);
		
		$this->expectException(InvalidDimensionException::class);
		$this->expectExceptionMessage("Invalid Dimension");
		$kingdom = new Kingdom(1,1);
		
		$this->expectException(InvalidObjectException::class);
		$this->expectExceptionMessage("Invalid Dimension");
		$kingdom = new Kingdom(1,4);
    }
	
    public function testValidMove()
    {		
		$kingdom = new Kingdom(7,6);
		$this->assertTrue($kingdom->isMoveValid(1,3));
        
		$point = new Point(4,5);
		$queen = new Person($point, "WEST");
		$kingdom->addQueen($queen);
		$this->assertTrue($kingdom->isMoveValid(0,1));
		$this->assertFalse($kingdom->isMoveValid(1,2));
    }
	
	public function testRotation()
    {
		$kingdom = new Kingdom(5,5);
        
		$point = new Point(5,3);
		$queen = new Person($point, "WEST");
		$kingdom->addQueen($queen);
		$this->assertEquals('NORTH', $kingdom->rotate("RIGHT"));
		$queen = new Person($point, "WEST");
		$kingdom->addQueen($queen);
		$this->assertEquals('SOUTH', $kingdom->rotate("LEFT"));
		
		$queen = new Person($point, "EAST");
		$kingdom->addQueen($queen);
		$this->assertEquals('NORTH', $kingdom->rotate("LEFT"));
		$queen = new Person($point, "EAST");
		$kingdom->addQueen($queen);
		$this->assertEquals('SOUTH', $kingdom->rotate("RIGHT"));
		
		$queen = new Person($point, "NORTH");
		$kingdom->addQueen($queen);
		$this->assertEquals('WEST', $kingdom->rotate("LEFT"));
		$queen = new Person($point, "NORTH");
		$kingdom->addQueen($queen);
		$this->assertEquals('EAST', $kingdom->rotate("RIGHT"));
		
		$queen = new Person($point, "SOUTH");
		$kingdom->addQueen($queen);
		$this->assertEquals('EAST', $kingdom->rotate("LEFT"));
		$queen = new Person($point, "SOUTH");
		$kingdom->addQueen($queen);
		$this->assertEquals('WEST', $kingdom->rotate("RIGHT"));		
		
		$this->expectException(InvalidDirectionException::class);		
		$this->expectExceptionMessage("Invalid rotation direction");
		$kingdom->rotate("UP");
    }
	
	public function testMove()
    {
		$kingdom = new Kingdom(8,9);
        $this->expectException(InvalidObjectException::class);
		$this->expectExceptionMessage("QUEEN MISSING");
		$kingdom->move();
		$point = new Point(8,11);
		$queen = new Person($point, "EAST");
		$kingdom->addQueen($queen);
		$this->expectException(InvalidMoveException::class);
		$this->expectExceptionMessage("Invalid move");
		$kingdom->move();
		$queen = new Person($point, "WEST");
		$kingdom->addQueen($queen);
		$this->assertTrue($kingdom->move());
    }
	
	public function testPlace()
    {
		$kingdom = new Kingdom(3,6);
        $this->expectException(InvalidMoveException::class);
		$this->expectExceptionMessage("Invalid move");
		$kingdom->place(4,6,"SOUTH");
		
		$this->assertTrue($kingdom->place(2,1,"EAST"));
		$point = new Point(8,11);
		$queen = new Person($point, "EAST");
		$kingdom->addQueen($queen);
		$this->assertTrue($kingdom->place(4,4,"NORTH"));
    }
	
	public function testOutput()
    {
		$kingdom = new Kingdom(2,5);
        $this->expectException(InvalidObjectException::class);
		$this->expectExceptionMessage("QUEEN MISSING");
		$kingdom->output();
		
		$point = new Point(1,2);
		$queen = new Person($point, "EAST");
		$kingdom->addQueen($queen);
		$this->assertEquals('4, 6, SOUTH', $kingdom->output());		
    }
}
