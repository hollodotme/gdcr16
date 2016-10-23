<?php
/**
 * @author hollodotme
 */

namespace GDCR16\GOL;

require(__DIR__ . '/../vendor/autoload.php');

$universe = Universe::getInitial();

header( 'Content-Type: text/plain;' );

$universe->buildGenerations(1);

