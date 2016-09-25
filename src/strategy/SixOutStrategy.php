<?php

namespace Pachisi\Strategy;
use Pachisi\Player;
use Pachisi\Board\GameBoardAbstract;
use Pachisi\Strategy\Status\RediceStatus;

/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:25
 */
class SixOutStrategy extends StrategyAbstract {

    protected function _applyStrategy(Player $player, $numberOfDicePoints, GameBoardAbstract $board) {
        if($numberOfDicePoints == 6) {
            $this->logStrategyDebug('Try to get out a man out of storage area');
            if($player->hasManInStartArea()) {
                $this->logStrategyDebug('Has free man!');
                $startField = $board->getPlayersStartField($player);
                if($startField->hasMan()) {
                    $this->logStrategyDebug('Start field is blocked...');
                    if($player->getPlayerIdentifier() !== $startField->getMan()->getPlayerIdentifier()) {
                        $this->logStrategyDebug('... by other player´s man...');
                        $newMan = $player->getOneManFromStartAreaField();
                        $board->moveToField($player, $startField, $newMan);
                        $this->logStrategyDebug("... kick out {$startField->getMan()->getManIdentifier()}!");
                        $this->logStrategyInfo("... Man {$newMan->getManIdentifier()} is out on players start field!");
                    } else {
                        $this->logStrategyDebug('... by own man.');
                    }
                } else {
                    $this->logStrategyDebug('Start field is free!');
                    $newMan = $player->getOneManFromStartAreaField();
                    $board->moveToField($player, $startField, $newMan);
                    $this->logStrategyInfo("... Man {$newMan->getManIdentifier()} gets out to players start field!");
                    return new RediceStatus();
                }
            }
            $this->logStrategyDebug('Player does NOT has free man!');
        }
    }


}