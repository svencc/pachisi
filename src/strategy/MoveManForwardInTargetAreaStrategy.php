<?php

namespace Pachisi\Strategy;
use Pachisi\Player;
use Pachisi\Man;
use Pachisi\Board\GameBoardAbstract;
use Pachisi\Strategy\Status\EndPlayersTurnStatus;

/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:25
 */
class MoveManForwardInTargetAreaStrategy extends StrategyAbstract {

    protected function _applyStrategy(Player $player, $numberOfDicePoints, GameBoardAbstract $board) {
        if($player->hasManInTargetArea()) {
            $targetArea = $board->getPlayersTargetArea($player);
            /** @var Man $man */
            foreach($targetArea->getManListFirstToLast() as $man) {
                if($board->isManMovableForward($player, $numberOfDicePoints, $man)) {
                    $this->logStrategyInfo("MOVEMENT: {$man->getManIdentifier()} start movement from {$man->getCurrentPosition()->getFieldNr()} ...");
                    $fieldToMove = $board->getFieldToMove($player, $numberOfDicePoints, $man);
                    $board->moveToField($player, $fieldToMove, $man);
                    $this->logStrategyInfo("... moved $numberOfDicePoints to field {$fieldToMove->getFieldNr()} (inner targetArea movement)");

                    return new EndPlayersTurnStatus();
                }
            }

            $this->logStrategyInfo("No movement possible.");

        }
    }
}