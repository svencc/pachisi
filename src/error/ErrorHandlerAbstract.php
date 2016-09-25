<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 25.09.2016
 * Time: 12:25
 */

namespace Pachisi\Error;
use Pachisi\Logger\iLoggerConsumer;
use Pachisi\Logger\LoggerServiceAbstract;



abstract class ErrorHandlerAbstract implements iLoggerConsumer {

    /** @var  LoggerServiceAbstract */
    protected $_loggerServiceName;
    protected $_errorTypes = E_ALL;

    /**
     * @param int $errorTypes
     */
    public function setErrorTypesToHandle($errorTypes) {
        $this->_errorTypes = (int) $errorTypes;
    }

    public function registerHandler() {
        set_error_handler (array($this, '_handleErrorAndLog'), $this->_errorTypes);
    }

    public function setLoggerServiceName($loggerServiceName) {
        $this->_loggerServiceName = $loggerServiceName;
    }

    public function _handleErrorAndLog($errno, $errstr, $errfile,  $errline, $errcontext) {
        $this->_logErrorOnService($errstr, $errfile, $errline, $errcontext);
        $this->_handle($errno, $errstr, $errfile,  $errline, $errcontext);
    }


    /**
     * @param $errstr
     * @param $errfile
     * @param $errcontext
     */
    protected function _logErrorOnService($errstr, $errfile, $errline, $errcontext) {
        if(!is_array($errcontext)) {
            $errcontext = get_object_vars($errcontext);
        }
        if ($this->_loggerServiceName !== NULL) {
            $service = $this->_loggerServiceName;
            $service::logger()->error("ERROR: '{$errstr}' in file '{$errfile}' in line '{$errline}'", $errcontext);
        }
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @param $errcontext
     *
     * @return mixed
     */
    abstract public function _handle($errno, $errstr, $errfile,  $errline, $errcontext);



}