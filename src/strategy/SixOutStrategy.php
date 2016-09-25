<?php

namespace Pachisi\Strategy;
use Pachisi\Logger\LoggerService;
use Pachisi\Player;
use Pachisi\Board\GameBoardAbstract;
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
            if($player->hasFreeManInStartArea()) {
                $this->logStrategyDebug('Has free man!');
                $startField = $board->getPlayersStartField($player);
                if($startField->hasMan()) {
                    $this->logStrategyDebug('Start field is blocked...');
                    if($player->getPlayerIdentifier() !== $startField->getMan()->getPlayerIdentifier()) {
                        $this->logStrategyDebug('... by other player´s man.');
                        $newMan = $board->getPlayersStartArea($player)->getFreeMan();
                        $this->logStrategyDebug("... kick out {$startField->getMan()->getManIdentifier()}!");
                        $board->resetManToStart($startField->getMan());
                        $startField->attachMan($newMan);
                        $this->logStrategyInfo("Man {$newMan->getManIdentifier()} is out on players start field!");
                    } else {
                        $this->logStrategyDebug('... by own man.');
                    }
                } else {
                    $this->logStrategyDebug('Start field is free!');
                    $newMan = $board->getPlayersStartArea($player)->getFreeMan();
                    $startField->attachMan($newMan);
                    $this->logStrategyInfo("Man {$newMan->getManIdentifier()} gets out to players start field!");
                }
            }
            $this->logStrategyDebug('Player does NOT has free man!');
        }
    }


}