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
class SixOutStrategy extends StrategyAbstract {

    protected function _applyStrategy(Player $player, $numberOfDicePoints, GameBoardAbstract $board) {
        if($numberOfDicePoints == 6) {
            if($player->hasManInStartArea()) {
                $startField = $board->getPlayersStartField($player);
                if($startField->hasMan()) {
                    if($player->getPlayerIdentifier() !== $startField->getMan()->getPlayerIdentifier()) {
                        $newMan = $board->getPlayersStartArea($player)->getFreeMan();
                        $board->resetManToStart($startField->getMan());
                        $startField->attachMan($newMan);
                    }
                } else {
                    $newMan = $board->getPlayersStartArea($player)->getFreeMan();
                    $board->resetManToStart($startField->getMan());
                    $startField->attachMan($newMan);
                }
            }
        }
    }
}