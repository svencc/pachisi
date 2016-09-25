<?php

namespace Pachisi\Strategy;
use Pachisi\Player;
use Pachisi\Board\GameBoardAbstract;
use Pachisi\Strategy\Status\EndPlayersTurnStatus;

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
                $this->logStrategyDebug('Player has man on start field.');
                $man = $player->getManOnStartField();

                if($board->isManMovableForward($player, $numberOfDicePoints, $man)) {
                    $this->logStrategyDebug('Man on start field can be moved');
                    $fieldToMove = $board->getFieldToMove($player, $numberOfDicePoints, $man);
                    $board->moveToField($player, $fieldToMove, $man);
                    $this->logStrategyInfo("{$man->getManIdentifier()} moved $numberOfDicePoints fields forward");
                } else {
                    $this->logStrategyDebug("Man on start field can´t be moved {$numberOfDicePoints} fields forward.");
                }

                return new EndPlayersTurnStatus();
            }
        }
    }
}