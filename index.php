<?php
require 'bootstrap.php';

$handler = new \Pachisi\Error\ErrorToExtepctionHandler();
$handler->registerHandler();
//$handler->setLoggerServiceName('\Pachisi\Logger\LoggerService');

\Pachisi\Logger\LoggerService::registerNewServiceConsumer($handler);

//trigger_error('svens test');

try{
    $game = \Pachisi\GameFactory::setup4PlayersGame();
    $game->runGame();

} catch(Exception $e) {
    \Pachisi\Logger\LoggerService::logException($e);
    throw $e;
}
