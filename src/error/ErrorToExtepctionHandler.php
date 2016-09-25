<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 25.09.2016
 * Time: 12:25
 */

namespace Pachisi\Error;


use Pachisi\Exception\ErrorException;

class ErrorToExtepctionHandler extends ErrorHandlerAbstract{

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @param $errcontext
     *
     * @return void
     * @throws ErrorException
     */
    public function _handle($errno, $errstr, $errfile,  $errline, $errcontext) {
        if(!is_array($errcontext)) {
            $errcontext = get_object_vars($errcontext);
        }
        throw new ErrorException(
            $errstr,
            $errno,
            $errfile,
            $errline,
            $errcontext
        );
    }

}