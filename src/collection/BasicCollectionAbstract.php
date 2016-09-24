<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 24.09.2016
 * Time: 11:51
 */

namespace Pachisi\Collection;
use Pachisi\Collection\Exception\KeyNotFoundException;
//use Pachisi\Collection\iCollectibleItem;

abstract class BasicCollectionAbstract {


    /**
     * @var iCollectibleItem[]
     */
    protected $_collection = array();

    /**
     * @param iCollectibleItem $item
     */
    protected function _addToCollection(iCollectibleItem $item) {
        $this->_collection[] = $item;
    }

    /**
     * Checks if an item is in the collection
     *
     * @param   iCollectibleItem $item    Collection to check
     *
     * @return bool
     */
    protected function _isInCollection(iCollectibleItem $item) {
        try {
            $this->findItem($item);
            return true;
        } catch(KeyNotFoundException $knfe) {
            return false;
        }
    }

    public function findItem($uid) {
        foreach($this->_collection as $item) {
            if($item->getUID() == $uid) {
                return $item;
            }
        }

        throw new KeyNotFoundException("The given key '{$uid}' is not included in the collection!");
    }

    /**
     * Use this function to iterate over the collection
     *
     * @return \Generator[iCollectibleItem]
     */
    abstract public function iterateCollection();

    public function leftShiftContent() {
        $firstItem  = array_shift($this->_collection);
        array_push($this->_collection, $firstItem);
    }
    public function shiftFirstItemFromCollection() {
        return array_shift($this->_collection);
    }
}