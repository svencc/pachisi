<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:04
 */

namespace Pachisi;


class Player {

    /**
     * @var Man[]
     */
    protected $_manList = array();

    /**
     * @return mixed
     */
    public function getIdentifier() {
        return $this->_id;
    }

    public function getManList() {
        return $this->_manList;
    }

    /**
     * @var string
     */
    protected $_id;

    public function __construct($playerIdentifier) {
        $this->_id  = $playerIdentifier;
        $this->_initMen();
    }

    protected function _initMen() {
        $this->_manList[]   = new Man($this->_id, 0);
        $this->_manList[]   = new Man($this->_id, 1);
        $this->_manList[]   = new Man($this->_id, 2);
        $this->_manList[]   = new Man($this->_id, 3);
    }

}