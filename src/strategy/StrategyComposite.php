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
class StrategyComposite extends StrategyAbstract  {

    /**
     * @var StrategyAbstract[]
     */
    private $_strategies = array();

    public function combineStrategy(StrategyAbstract $strategy) {
        $this->_strategies[] = $strategy;
    }

    protected function _applyStrategy(Player $player, $numberOfDicePoints, GameBoardAbstract $board) {
        foreach($this->_strategies as $strategy) {
            $strategy->play($player, $numberOfDicePoints, $board);
        }
    }

}