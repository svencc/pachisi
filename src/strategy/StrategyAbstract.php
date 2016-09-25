<?php

namespace Pachisi\Strategy;
use Pachisi\Player;
use Pachisi\Board\GameBoardAbstract;
use Pachisi\Logger\LoggerService;
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:25
 */
abstract class StrategyAbstract {

    /**
     * @param Player            $player
     * @param                   $numberOfDicePoints
     * @param GameBoardAbstract $board
     *
     * @return Status\StatusAbstract
     */
     public function play(Player $player, $numberOfDicePoints, GameBoardAbstract $board) {
         $this->logWhichStrategyApplied($player, $numberOfDicePoints);
         return $this->_applyStrategy($player, $numberOfDicePoints, $board);
    }

    /**
     * @param Player            $player
     * @param                   $numberOfDicePoints
     * @param GameBoardAbstract $board
     *
     * @return \Pachisi\Strategy\Status\StatusAbstract
     */
    abstract protected function _applyStrategy(Player $player, $numberOfDicePoints, GameBoardAbstract $board);

    /**
     * @param Player $player
     * @param        $numberOfDicePoints
     * @param        $caller
     */
    protected function logWhichStrategyApplied(Player $player, $numberOfDicePoints) {
        $caller = get_called_class();
        LoggerService::logger()->debug("Player '{$player->getPlayerIdentifier()}' applies '{$caller}' with an ".
            "eyes number of {$numberOfDicePoints}.");
    }

    /**
     * @param string $info
     */
    protected function logStrategyInfo($info) {
        $caller = get_called_class();
        LoggerService::logger()->info("{$caller}: {$info}");
    }

    /**
     * @param Player $player
     * @param        $numberOfDicePoints
     * @param        $caller
     */
    protected function logStrategyDebug($info) {
        $caller = get_called_class();
        LoggerService::logger()->debug("{$caller}: {$info}");
    }
}