<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\{Point,Person,InvalidFaceException};

class PersonTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGettersAndSetters()
    {
        $point = new Point(6,4);		
		$queen = new Person($point, "EAST");
		$this->assertEquals("EAST", $queen->getFace());
		//$this->assertEquals(4, $queen->getposition()->getY());
		//$this->assertEquals(6, $queen->getposition()->getX());
		$this->assertEquals($point, $queen->getposition());		
		
		$queen->setFace("NORTH");
		$this->assertEquals("NORTH", $queen->getFace());				
    }
	
	public function testAllowedFaces()
    {
        $point = new Point(6,4);		
		$queen = new Person($point, "EAST");		
		$this->assertEquals(["NORTH","EAST","SOUTH","WEST"], $queen->getAllowedFaces());
		$this->assertCount(4, $queen->getAllowedFaces());
		
        $this->expectException(InvalidFaceException::class);
		$this->expectExceptionMessage("Invalid Face value");
		$queen = new Person($point, "SOUTH-EAST");
    }
}
