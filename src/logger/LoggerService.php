<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 25.09.2016
 * Time: 07:44
 */

namespace Pachisi\Logger;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerService extends LoggerServiceAbstract  {

    const SERVICE_NAME = '\\Pachisi\\Logger\\LoggerService';

    /**
     * @return Logger
     */
    protected function _initLogger() {
        $logger = new Logger('pachisi');
        $logger->pushHandler(new StreamHandler(LOG_FILE, Logger::INFO));
        $logger->pushHandler(new StreamHandler(DEBUG_LOG_FILE, Logger::DEBUG));
        $logger->pushHandler(new StreamHandler(ERROR_LOG_FILE, Logger::ERROR));
        return $logger;
    }

    public static function truncateLogs() {
        $log = fopen(LOG_FILE, 'w' );
        fclose($log);
        $debugLog = fopen(DEBUG_LOG_FILE, 'w' );
        fclose($debugLog);
        $errorLog = fopen(ERROR_LOG_FILE, 'w' );
        fclose($errorLog);
    }

    public static function registerNewServiceConsumer(iLoggerConsumer $consumer) {
        $consumer->setLoggerServiceName(LoggerService::SERVICE_NAME);
    }
}