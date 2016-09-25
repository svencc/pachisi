<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 25.09.2016
 * Time: 07:44
 */

namespace Pachisi\Logger;


use Monolog\Logger;

abstract class LoggerServiceAbstract implements iLoggerProvider {

    protected static $_instance = NULL;

    /** @var Logger */
    protected $_logger;

    protected function __construct() {
        $this->_logger = $this->_initLogger();
    }

    /**
     * @return Logger
     */
    abstract protected function _initLogger();

    /**
     * @return Logger
     */
    public static function logger() {
        if (self::$_instance == NULL) {
            self::$_instance = new static();
        }

        return self::$_instance->_logger;
    }

    public static function logException(\Exception $e) {
        $exceptionType = get_class($e);
        $message = "UNCATCHED EXCEPTION of type '{$exceptionType}'"
        ." with MESSAGE: '{$e->getMessage()}'"
        ." in FILE: '{$e->getFile()}'"
        ." in LINE: '{$e->getLine()}"
        ." occured!";
        self::logger()->error($message, $e->getTrace());
    }

    abstract public static function truncateLogs();

    abstract public static function registerNewServiceConsumer(iLoggerConsumer $consumer);


}