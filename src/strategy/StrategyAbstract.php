<?php

namespace Pachisi\Strategy;
use Pachisi\Player;
use Pachisi\Board\GameBoardAbstract;
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:25
 */
abstract class StrategyAbstract {

     public function play(Player $player, $numberOfDicePoints, GameBoardAbstract $board) {
        $this->_applyStrategy($player, $numberOfDicePoints, $board);
    }

    abstract protected function _applyStrategy(Player $player, $numberOfDicePoints, GameBoardAbstract $board);

}