<?php

/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 22:29
 */

namespace Pachisi\Exception;

use Pachisi\Player;

class VictoryException extends \Exception {

    /** @var  Player */
    protected $_playerWon;

    /**
     * @return Player
     */
    public function getPlayerWon() {
        return $this->_playerWon;
    }

    public function __construct(Player $player) {
        $this->_playerWon = $player;
        parent::__construct("Game Over! {$player->getPlayerIdentifier()} won the game!");
    }

}