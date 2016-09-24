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

                if($board->canManBeMovedForward($player, $numberOfDicePoints, $man)) {
                    $fieldToMove = $board->getFieldToMove($player, $numberOfDicePoints, $man);
                    $board->moveToField($player, $fieldToMove, $man);
                }
            }
        }
    }
}