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
class ClearStartFieldStrategy extends StrategyAbstract {

    protected function _applyStrategy(Player $player, $numberOfDicePoints, GameBoardAbstract $board) {
        if($player->hasManOnBoard()) {
            if($player->hasManOnStartField()) {
                $man = $player->getManOnStartField();
                if($man->canManOnStartFieldBeMovedForward($numberOfDicePoints, $board)) {
                    $man->moveMan($numberOfDicePoints, $board);
                    return true;
                } else {
                    return false;
                }
            }
        }

        return true;
    }
}