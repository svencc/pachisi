<?php
require 'config.php';
$loader = require __DIR__ . '/vendor/autoload.php';

new \Pachisi\GameController();

$game = \Pachisi\GameFactory::setup4PlayersGame();
$game->runGame();
