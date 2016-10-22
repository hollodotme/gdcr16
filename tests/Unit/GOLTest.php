<?php
/**
 * @author hollodotme
 */

namespace GDCR16\GOL\Tests\Unit;

use GDCR16\GOL\Universe;

class GOLTest extends \PHPUnit_Framework_TestCase
{
	public function testUnderPopulation()
	{
		$universe = Universe::getInitial();

		$next = $universe->getNextGeneration();

		$this->assertNull( $next->getCellAt( 1, 2 ) );
		$this->assertNull( $next->getCellAt( 3, 2 ) );
		$this->assertNotNull( $next->getCellAt( 2, 2 ) );
	}

	public function testSurvival()
	{
		$universe = Universe::getInitial();

		$next = $universe->getNextGeneration();

		$this->assertNotNull( $next->getCellAt( 2, 2 ) );
		$this->assertNotNull( $next->getCellAt( 2, 7 ) );
		$this->assertNotNull( $next->getCellAt( 3, 7 ) );
		$this->assertNotNull( $next->getCellAt( 3, 6 ) );
		$this->assertNull( $next->getCellAt( 1, 7 ) );
		$this->assertNull( $next->getCellAt( 2, 5 ) );
	}

	public function testOvercrowding()
	{
	}

	public function testReproduciton()
	{
		$universe = Universe::getInitial();

		$next = $universe->getNextGeneration();

		$this->assertNotNull( $next->getCellAt( 2, 1 ) );
		$this->assertNotNull( $next->getCellAt( 2, 3 ) );
		$this->assertNull( $next->getCellAt( 2, 6 ) );
		$this->assertNotNull( $next->getCellAt( 2, 8 ) );
	}
}
