<?php
require 'config.php';
//require __DIR__ . '/vendor/autoload.php';

$loader = require __DIR__ . '/vendor/autoload.php';
echo 'hallo';

\Pachisi\GameBoardAbstract::bla();
$test = new Pachisi\GameBoardAbstract();
var_dump($test->hello() );
