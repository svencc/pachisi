<?php
require __DIR__ . '/vendor/autoload.php';
require 'config.php';

$handler = new \Pachisi\Error\ErrorToExtepctionHandler();
$handler->registerHandler();
$handler->setLoggerServiceName('\Pachisi\Logger\LoggerService');

//trigger_error('svens test');

try{
    $game = \Pachisi\GameFactory::setup4PlayersGame();
    $game->runGame();

} catch(Exception $e) {
    \Pachisi\Logger\LoggerService::logException($e);
    throw $e;
}
