<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 24.09.2016
 * Time: 16:24
 */

namespace Pachisi\Validator;
use \Pachisi\Validator\Exception\OutOfRangeException;

abstract class Validator {

    /**
     * Checks if the given $numberToValidate is in range between $min and $max
     *
     * @param   integer $min    The min value
     * @param   integer $max    The max value
     * @param   integer $numberToValidate    The number to validate
     *
     * @return  bool
     * @throws  OutOfRangeException
     */
    public static function _validateRange($min, $max, $numberToValidate) {
        if($numberToValidate >= $min && $numberToValidate <= $max) {
            return true;
        } else {
            throw new OutOfRangeException();
        }
    }
}