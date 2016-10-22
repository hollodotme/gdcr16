<?php
/**
 * @author hollodotme
 */

namespace GDCR16\GOL;

require(__DIR__ . '/../vendor/autoload.php');

$universe = Universe::getInitial();

header( 'Content-Type: text/plain;' );

$universe->print();

for ( $i = 0; $i < 10; $i++ )
{
	sleep( 1 );

	echo "\n\n";
	$universe = $universe->getNextGeneration();
	$universe->print();
}

