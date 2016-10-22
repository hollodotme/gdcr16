<?php declare(strict_types=1);
/**
 * @author hollodotme
 */

namespace GDCR16\GOL;

/**
 * Class Universe
 * @package GDCR16\GOL
 */
class Universe
{
	/** @var int */
	private $generation;

	/** @var int */
	private $sizeX;

	/** @var int */
	private $sizeY;

	/** @var Cell[] */
	private $cells;

	/**
	 * @param int $sizeX
	 * @param int $sizeY
	 */
	public function __construct( int $generation, int $sizeX, int $sizeY )
	{
		$this->generation = $generation;
		$this->sizeX      = $sizeX;
		$this->sizeY      = $sizeY;
		$this->cells      = [];
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

	/**
	 * @return int
	 */
	public function getSizeX(): int
	{
		return $this->sizeX;
	}

	/**
	 * @return int
	 */
	public function getSizeY(): int
	{
		return $this->sizeY;
	}

	public function getNextGeneration() : Universe
	{
		$universe = new Universe( $this->generation + 1, $this->getSizeX(), $this->getSizeY() );

		// Berechnung
		for ( $x = 0; $x < $this->getSizeX(); $x++ )
		{
			for ( $y = 0; $y < $this->getSizeY(); $y++ )
			{
				$cell = $this->getCellAt( $x, $y );

				if ( $cell === null )
				{
					$cellsAround = $this->countCellsAround( $x, $y );
					if ( $cellsAround == 3 )
					{
						$universe->addCell( new Cell( $x, $y ) );
					}
				}
				else
				{
					$cellsAround = $this->countCellsAround( $x, $y );
					if ( in_array( $cellsAround, [ 2, 3 ] ) )
					{
						$universe->addCell( new Cell( $x, $y ) );
					}
				}
			}
		}

		return $universe;
	}

	private function countCellsAround( $x, $y ) : int
	{
		$count = 0;

		if ( $this->getCellAt( $x - 1, $y ) !== null )
		{
			$count++;
		}

		if ( $this->getCellAt( $x + 1, $y ) !== null )
		{
			$count++;
		}

		if ( $this->getCellAt( $x - 1, $y - 1 ) !== null )
		{
			$count++;
		}

		if ( $this->getCellAt( $x, $y - 1 ) !== null )
		{
			$count++;
		}

		if ( $this->getCellAt( $x + 1, $y - 1 ) !== null )
		{
			$count++;
		}

		if ( $this->getCellAt( $x + 1, $y + 1 ) !== null )
		{
			$count++;
		}

		if ( $this->getCellAt( $x, $y + 1 ) !== null )
		{
			$count++;
		}

		if ( $this->getCellAt( $x - 1, $y + 1 ) !== null )
		{
			$count++;
		}

		return $count;
	}

	public function print()
	{
		echo "GENERATION: " . $this->generation . "\n";
		echo str_repeat( "=", $this->getSizeX() * 5 ) . "\n";

		for ( $i = 0; $i < $this->getSizeY(); $i++ )
		{
			echo "|";

			for ( $j = 0; $j < $this->getSizeX(); $j++ )
			{
				if ( $this->getCellAt( $j, $i ) !== null )
				{
					echo "LEBT";
				}
				else
				{
					echo "    ";
				}

				echo "|";
			}

			echo "\n";
		}

		echo str_repeat( "=", $this->getSizeX() * 5 ) . "\n";
	}

	public static function getInitial()
	{
		$universe = new self( 1, 20, 20 );
		$universe->addCell( new Cell( 1, 2 ) );
		$universe->addCell( new Cell( 2, 2 ) );
		$universe->addCell( new Cell( 3, 2 ) );
		$universe->addCell( new Cell( 2, 5 ) );
		$universe->addCell( new Cell( 3, 6 ) );
		$universe->addCell( new Cell( 1, 7 ) );
		$universe->addCell( new Cell( 2, 7 ) );
		$universe->addCell( new Cell( 3, 7 ) );

		return $universe;
	}
}
