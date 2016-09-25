<?php

namespace Pachisi\Strategy;
use Pachisi\Player;
use Pachisi\Board\GameBoardAbstract;
use Pachisi\Strategy\Status\EndPlayersTurnStatus;
use Pachisi\Strategy\Status\RediceStatus;

/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:25
 */
class StrategyComposite extends StrategyAbstract  {

    /**
     * @var StrategyAbstract[]
     */
    private $_strategies = array();

    public function queueStrategy(StrategyAbstract $strategy) {
        $this->_strategies[] = $strategy;
    }

    /**
     * @param Player            $player
     * @param                   $numberOfDicePoints
     * @param GameBoardAbstract $board
     *
     * @return Status\StatusAbstract
     */
    protected function _applyStrategy(Player $player, $numberOfDicePoints, GameBoardAbstract $board) {
        foreach($this->_strategies as $strategy) {
            $status = $strategy->play($player, $numberOfDicePoints, $board);

            if($status instanceof EndPlayersTurnStatus) {
                $this->logStrategyInfo("Player '{$player->getPlayerIdentifier()}' ends his turn.");
                return $status;
            } elseif($status instanceof RediceStatus) {
                $this->logStrategyInfo("Player '{$player->getPlayerIdentifier()}' has to redice during his turn.");
                return $status;
            } else {
                continue;
            }
        }
    }

}