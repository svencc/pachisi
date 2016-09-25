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
use Pachisi\Field\EndField;
use Pachisi\Field\RegularMovementField;
use Pachisi\Field\StartAreaField;
use Pachisi\Field\StartField;
use Pachisi\Field\TargetAreaField;

class Player implements iCollectibleItem {

    /** @var  ManCollection */
    protected $_manCollection;

    /**
     * @var string
     */
    protected $playerIdentifier;

    /**
     * @return mixed
     */
    public function getPlayerIdentifier() {
        return $this->playerIdentifier;
    }

    public function __construct($playerIdentifier) {
        $this->playerIdentifier  = $playerIdentifier;
        $this->_initMen();
    }
    /**
     * @return bool
     */
    public function hasManOnBoard() {
        /** @var Man $man */
        foreach($this->_manCollection->iterateCollection() as $man) {
            if( $man->getCurrentPosition() instanceof RegularMovementField ||
                $man->getCurrentPosition() instanceof StartField ||
                $man->getCurrentPosition() instanceof EndField
            ) {
                return true;
            } else {
                continue;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasManOnStartField() {
        /** @var Man $man */
        foreach($this->_manCollection->iterateCollection() as $man) {
            if($man->getCurrentPosition() instanceof StartField) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasManInStartArea() {
        /** @var Man $man */
        foreach($this->_manCollection->iterateCollection() as $man) {
            if($man->getCurrentPosition() instanceof StartAreaField) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasManInTargetArea() {
        /** @var Man $man */
        foreach($this->_manCollection->iterateCollection() as $man) {
            if($man->getCurrentPosition() instanceof TargetAreaField) {
                return true;
            }
        }

        return false;
    }


    /**
     * @return Man
     * @throws RequestedItemNotFoundException
     */
    public function getManOnStartField() {
        /** @var Man $man */
        foreach($this->_manCollection->iterateCollection() as $man) {
            if($man->getCurrentPosition() instanceof StartField) {
                return $man;
            }
        }

        throw new RequestedItemNotFoundException("There is no man on StartField!");
    }

    /**
     * @return Man
     * @throws RequestedItemNotFoundException
     */
    public function getOneManFromStartAreaField() {
        /** @var Man $man */
        foreach($this->_manCollection->iterateCollection() as $man) {
            if($man->getCurrentPosition() instanceof StartAreaField) {
                return $man;
            }
        }

        throw new RequestedItemNotFoundException("There is no man on StartAreaField!");
    }

    /**
     * @return Man[]
     */
    public function getManList() {
        $list = array();
        foreach($this->_manCollection->iterateCollection() as $man) {
            $list[] = $man;
        }

        return $list;
    }

    protected function _initMen() {
        $this->_manCollection = new ManCollection();
        $this->_manCollection->addToCollection(new Man($this->playerIdentifier, 0));
        $this->_manCollection->addToCollection(new Man($this->playerIdentifier, 1));
        $this->_manCollection->addToCollection(new Man($this->playerIdentifier, 2));
        $this->_manCollection->addToCollection(new Man($this->playerIdentifier, 3));
    }

    /**
     * @return string
     */
    public function getUID() {
        return $this->playerIdentifier;
    }

    /**
     * @return bool
     */
    public function isVictorious() {
        $manOnTargetAreaFields = array();
        foreach($this->_manCollection->iterateCollection() as $man) {
            if($man->getCurrentPosition() instanceof TargetAreaField) {
                $manOnTargetAreaFields[] = $man;
            }
        }

        if(count($manOnTargetAreaFields) == 4) {
            return true;
        } else {
            return false;
        }
    }

}