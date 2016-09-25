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
class BringManInTargetAreaStrategy extends StrategyAbstract {

    protected function _applyStrategy(Player $player, $numberOfDicePoints, GameBoardAbstract $board) {
        if($player->hasManOnBoard()) {

        }
        // TODO: Implement _applyStrategy() method.
    }
}