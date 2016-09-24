<?php

/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:06
 */

namespace Pachisi\Field;
use Pachisi\Field\RegularFieldAbstract;
use Pachisi\Player;

class PlayerRelatedField extends RegularField  {

    /**
     * @var string  The playerIdentifier this field belongs to
     */
    protected $_relatedPlayerIdentifier;

    public function __construct(Player $player) {
        $this->_relatedPlayerIdentifier = $player->getPlayerIdentifier();
    }

    /**
     * @return string   Returns the related player (owner) of that field
     */
    public function getRelatedPlayerIdentifier() {
        return $this->_relatedPlayerIdentifier;
    }
}