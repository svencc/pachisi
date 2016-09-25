<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:04
 */

namespace Pachisi;
use Monolog\Logger;
use Pachisi\Collection\Exception\RequestedItemNotFoundException;
use Pachisi\Collection\iCollectibleItem;
use Pachisi\Collection\ManCollection;
use Pachisi\Field\StartStorageField;
use Pachisi\Field\StartField;
use Pachisi\Logger\LoggerService;

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
            if( $man->getCurrentPosition() === null || $man->getCurrentPosition() instanceof StartStorageField ) {
                continue;
            } else {
                return true;
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
    public function hasFreeManInStartArea() {
        LoggerService::logger()->debug("hasFreeManInStartArea?");
        /** @var Man $man */
        foreach($this->_manCollection->iterateCollection() as $man) {
            if($man->getCurrentPosition() instanceof StartStorageField) {
                LoggerService::logger()->debug("{$man->getManIdentifier()} -> ".get_class($man->getCurrentPosition()));
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

}