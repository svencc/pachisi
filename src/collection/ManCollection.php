<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 24.09.2016
 * Time: 11:51
 */

namespace Pachisi\Collection;
use Pachisi\Man;

class ManCollection extends BasicCollectionAbstract {

    /**
     * @param iCollectibleItem $item
     */
    public function addToCollection(Man $item) {
        parent::_addToCollection($item);
    }

    /**
     * Checks if an item is in the collection
     *
     * @param   iCollectibleItem $item    Collection to check
     *
     * @return bool
     */
    public function isInCollection(Man $item) {
        return parent::_isInCollection($item);
    }

    /**
     * Use this function to iterate over the collection
     *
     * @return \Generator[Man]
     */
    public function iterateCollection() {
        foreach ($this->_collection as $item) {
            yield $item;
        }
    }

}