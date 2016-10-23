<?php declare(strict_types = 1);
/**
 * @author hollodotme
 */

namespace GDCR16\GOL;

/**
 * Class Universe
 * @package GDCR16\GOL
 */
final class Universe
{
	/** @var int */
	private $generation;

	/** @var Cell[] */
	private $cells;

	public function __construct( int $generation )
	{
		$this->generation = $generation;
		$this->cells      = [];
	}

	public function getGeneration(): int
	{
		return $this->generation;
	}

	public function addCell( Cell $cell )
	{
		$this->cells[] = $cell;
	}

	/**
	 * @param $x
	 * @param $y
	 *
	 * @return Cell|null
	 */
	public function getCellAt( $x, $y )
	{
		foreach ( $this->cells as $cell )
		{
			if ( $cell->getX() == $x && $cell->getY() == $y )
			{
				return $cell;
			}
		}

		return null;
	}

	public function getNextGeneration() : Universe
	{
		$nextUniverse = new Universe( $this->generation + 1 );

		$this->addLivingCellsOfNextGeneration( $this->cells, 0, $nextUniverse, 0 );

		return $nextUniverse;
	}

	private function addLivingCellsOfNextGeneration( array $cells, int $index, Universe $nextUniverse, int $depth )
	{
		if ( isset($cells[ $index ]) )
		{
			$this->checkCell( $cells[ $index ], $nextUniverse, $depth );

			$this->addLivingCellsOfNextGeneration( $cells, $index + 1, $nextUniverse, $depth );
		}
	}

	private function checkCell( Cell $cell, Universe $universe, int $depth )
	{
		if ( $depth < 2 )
		{
			$livingNeighbours = $this->countLivingNeighboursOf( $cell );

			if ( $livingNeighbours == 3 && !$this->cellExists( $cell ) )
			{
				$universe->addCell( $cell );
			}

			if ( in_array( $livingNeighbours, [ 2, 3 ] ) && $this->cellExists( $cell ) )
			{
				$universe->addCell( $cell );
			}

			if ( $depth < 1 )
			{
				$neighbours = $this->getNeighbours( $cell );

				$this->addLivingCellsOfNextGeneration( $neighbours, 0, $universe, $depth + 1 );
			}
		}
	}

	private function countLivingNeighboursOf( Cell $cell ) : int
	{
		$neighbours       = $this->getNeighbours( $cell );
		$livingNeighbours = array_filter( $neighbours, [ $this, 'cellExists' ] );

		return count( $livingNeighbours );
	}

	private function getNeighbours( Cell $cell )
	{
		$coordOffsets = [ [ -1, -1 ], [ 0, -1 ], [ 1, -1 ], [ 1, 0 ], [ 1, 1 ], [ -1, 1 ], [ -1, 0 ] ];

		$neighbours = array_map(
			function ( array $offsets ) use ( $cell )
			{
				return new Cell( $cell->getX() + $offsets[0], $cell->getY() + $offsets[1] );
			},
			$coordOffsets
		);

		return $neighbours;
	}

	private function cellExists( Cell $cell )
	{
		return in_array( $cell, $this->cells );
	}


	public function print()
	{
		echo "GENERATION: " . $this->generation . "\n";
		print_r( $this->cells );
	}

	public static function getInitial()
	{
		$universe = new self( 1, 20, 20 );
		$universe->addCell( new Cell( 1, 2 ) );
		$universe->addCell( new Cell( 2, 2 ) );
		$universe->addCell( new Cell( 3, 2 ) );

		/*
		$universe->addCell( new Cell( 2, 5 ) );
		$universe->addCell( new Cell( 3, 6 ) );
		$universe->addCell( new Cell( 1, 7 ) );
		$universe->addCell( new Cell( 2, 7 ) );
		$universe->addCell( new Cell( 3, 7 ) );
		*/

		return $universe;
	}
}
