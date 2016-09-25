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

abstract class LoggerServiceAbstract {

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

    abstract public static function truncateLogs();
}