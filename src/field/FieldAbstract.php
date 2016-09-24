<?php

/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:06
 */

namespace Pachisi\Field;
use Pachisi\Man;
use Pachisi\Field\Exception\FieldIsNotEmptyException;
use Pachisi\Field\Exception\FieldIsEmptyException;

/**
 * Class FieldAbstract
 * @package Pachisi\Field
 */
abstract class FieldAbstract {

    /** @var  Man */
    protected $_man;

    /**
     * @param $man
     *
     * @throws FieldIsNotEmptyException
     */
    public function attachMan(Man $man) {
        if($this->hasMan()) {
            throw new FieldIsNotEmptyException();
        }
        $this->_man = $man;
        $man->setCurrentPosition($this);
    }

    /**
     * @return Man
     * @throws FieldIsEmptyException
     */
    public function detachMan() {
        if($this->hasMan() == false) {
            throw new FieldIsEmptyException();
        } else {
            $man = $this->_man;
            $this->_man = null;
            $man->removeCurrentPosition();

            return $man;
        }
    }

    /**
     * @return bool
     */
    public function hasMan() {
        return ($this->_man instanceof Man) ? true : false;
    }


}