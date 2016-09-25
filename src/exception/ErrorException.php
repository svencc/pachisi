<?php

/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 22:29
 */

namespace Pachisi\Exception;

class ErrorException extends PachisiException {

    protected $_errfile;
    protected $_errline;
    protected $_errcontext;

    public function __construct($errstr, $errno, $errfile, $errline, $errcontext) {
        $this->_errfile = $errfile;
        $this->_errline = $errline;
        $this->_errcontext = $errcontext;
        parent::__construct($errstr, $errno);
    }

    /**
     * @return mixed
     */
    public function getErrcontext() {
        return $this->_errcontext;
    }

    /**
     * @return \Exception
     */
    public function getErrfile() {
        return $this->_errfile;
    }

    /**
     * @return mixed
     */
    public function getErrline() {
        return $this->_errline;
    }
}