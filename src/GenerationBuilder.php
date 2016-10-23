<?php
/**
 * @author hollodotme
 */

namespace GDCR16\GOL;

/**
 * Class GenerationBuilder
 * @package GDCR16\GOL
 */
final class GenerationBuilder
{
	/** @var Universe */
	private $universe;

	/** @var int */
	private $generations;

	/**
	 * @param Universe $universe
	 * @param int      $generations
	 */
	public function __construct( Universe $universe, int $generations )
	{
		$this->universe    = $universe;
		$this->generations = $generations;
	}

	public function printGenerations()
	{
		$this->universe->print();

		if ( $this->generations > $this->universe->getGeneration() )
		{
			$this->universe = $this->universe->getNextGeneration();
			$this->printGenerations();
		}
	}
}
