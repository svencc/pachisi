<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:04
 */

namespace Pachisi;
use Pachisi\Collection\Exception\RequestedItemNotFoundException;
use Pachisi\Collection\iCollectibleItem;
use Pachisi\Collection\ManCollection;
use Pachisi\Field\StartField;

class Player implements iCollectibleItem {

    /** @var  ManCollection */
    protected $_manCollection;

    /**
     * @return mixed
     */
    public function getIdentifier() {
        return $this->_id;
    }

    public function hasManOnBoard() {
        /** @var Man $man */
        foreach($this->_manCollection->iterateCollection() as $man) {
            if($man->getCurrentPosition() === null || $man->getCurrentPosition() instanceof StartField) {
                continue;
            } else {
                return true;
            }
        }

        return false;
    }

    public function hasManOnStartField() {
        /** @var Man $man */
        foreach($this->_manCollection->iterateCollection() as $man) {
            if($man->getCurrentPosition() instanceof StartField) {
                return true;
            }
        }

        return false;
    }

    public function getManOnStartField() {
        /** @var Man $man */
        foreach($this->_manCollection->iterateCollection() as $man) {
            if($man->getCurrentPosition() instanceof StartField) {
                return $man;
            }
        }

        throw new RequestedItemNotFoundException("There is no man on StartField!");
    }

//    public function getManCollection() {
//        return $this->_manCollection;
//    }

    public function getManList() {
        $list = array();
        foreach($this->_manCollection->iterateCollection() as $man) {
            $list[] = $man;
        }

        return $list;
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
        $this->_manCollection = new ManCollection();
        $this->_manCollection->addToCollection(new Man($this->_id, 0));
        $this->_manCollection->addToCollection(new Man($this->_id, 1));
        $this->_manCollection->addToCollection(new Man($this->_id, 2));
        $this->_manCollection->addToCollection(new Man($this->_id, 3));
    }

    /**
     * @return string
     */
    public function getUID() {
        return $this->_id;
    }

}