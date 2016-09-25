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
class MoveManForwardOnBoardStrategy extends StrategyAbstract {

    protected function _applyStrategy(Player $player, $numberOfDicePoints, GameBoardAbstract $board) {
        if($player->hasManOnBoard()) {
            $orderedManList = $board->getPlayersManWithAscendingDistanzToEndField($player);

            foreach($orderedManList as $man) {
                if($board->isManMovableForward($player, $numberOfDicePoints, $man )) {
                    $fieldToMove = $board->getFieldToMove($player, $numberOfDicePoints, $man);
                    $board->moveToField($player, $fieldToMove, $man);

                    return new EndPlayersTurnStatus();
                }
            }
        }
    }
}