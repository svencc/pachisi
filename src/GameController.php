<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:04
 */

namespace Pachisi;


use Pachisi\Collection\PlayerCollection;
use Pachisi\Dice\DiceAbstract;
use Pachisi\Strategy\StrategyAbstract;

class GameController {

    const PLAYER_ID_1   = 'blau';
    const PLAYER_ID_2   = 'grün';
    const PLAYER_ID_3   = 'gelb';
    const PLAYER_ID_4   = 'rot';

    /**
     * @var Player[]
     */
    protected $_playerList = array();

    /**
     * @var DiceAbstract
     */
    protected $_dice;

    /**
     * @var Board\GameBoardAbstract
     */
    protected $_gameBoard;

    /** @var  StrategyAbstract */
    protected $_strategy;

    public function addPlayers(PlayerCollection $collection) {
        /** @var Player $player */
        foreach($collection->iterateCollection() as $player) {
            $this->_addPlayer($player);
        }
    }

    public function _addPlayer(Player $player) {
        $this->_playerList[]   = $player;
    }

    public function addDice(DiceAbstract $dice) {
        $this->_dice = $dice;
    }

    public function addBoard(Board\GameBoardAbstract $board) {
        $this->_gameBoard = $board;
    }

    public function addStrategy(StrategyAbstract $strategy) {
        $this->_strategy = $strategy;
    }


    public function runGame() {
        do {
            $victory = $this->playRound();
        } while($victory == false);
    }

    protected function playRound() {
        var_dump('next round');
        foreach($this->_playerList as $player) {
            $numberOfDicePoints = $this->_dice->rollDice();
            $this->_strategy->play($player, $numberOfDicePoints, $this->_gameBoard);

            // PRÜFE SIEGBEDINGUNG
        }

        // PRÜFE SIEGBEDINGUNG
        return false;
    }


}