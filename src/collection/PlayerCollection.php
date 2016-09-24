<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 24.09.2016
 * Time: 11:51
 */

namespace Pachisi\Collection;
use Pachisi\Player;

class PlayerCollection extends BasicCollectionAbstract {

    /**
     * @param iCollectibleItem $item
     */
    public function addToCollection(Player $item) {
        parent::_addToCollection($item);
    }

    /**
     * Checks if an item is in the collection
     *
     * @param   iCollectibleItem $item    Collection to check
     *
     * @return bool
     */
    public function isInCollection(Player $item) {
        return parent::_isInCollection($item);
    }

    /**
     * Use this function to iterate over the collection
     *
     * @return \Generator[Player]
     */
    public function iterateCollection() {
        foreach ($this->_collection as $item) {
            yield $item;
        }
    }

}