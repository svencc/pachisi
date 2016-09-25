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
use Pachisi\Exception\VictoryException;
use Pachisi\Logger\LoggerService;
use Pachisi\Strategy\Status\RediceStatus;
use Pachisi\Strategy\StrategyAbstract;

class GameEngine {

    const PLAYER_ID_1   = 'A';
    const PLAYER_ID_2   = 'B';
    const PLAYER_ID_3   = 'C';
    const PLAYER_ID_4   = 'D';

    /** @var Player[] */
    protected $_playerList = array();

    /** @var DiceAbstract */
    protected $_dice;

    /** @var Board\GameBoardAbstract */
    protected $_gameBoard;

    /** @var  StrategyAbstract */
    protected $_strategy;

    /** @var  Renderer */
    protected $_renderer;

    public function addPlayers(PlayerCollection $collection) {
        /** @var Player $player */
        foreach($collection->iterateCollection() as $player) {
            $this->_addPlayer($player);
        }
    }

    /**
     * @return Player[]
     */
    public function getPlayers() {
        return $this->_playerList;
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

    public function getBoard() {
        return $this->_gameBoard;
    }

    public function addStrategy(StrategyAbstract $strategy) {
        $this->_strategy = $strategy;
    }

    public function addRenderer(Renderer $renderer) {
        $this->_renderer = $renderer;
    }


    public function runGame() {
        $roundNr = 1;
        LoggerService::logger()->info('Start game');
        try{
            do {
                $this->playRound($roundNr);
                $roundNr++;
            } while(true);
        } catch(VictoryException $ve) {
            LoggerService::logger()->info("{$ve->getPlayerWon()->getPlayerIdentifier()} win the game!");
            $this->_renderer->announceTheWinner($ve->getPlayerWon());
            exit;
        }
    }

    protected function playRound($roundNr) {
        LoggerService::logger()->info("Start new game round {$roundNr}");
        foreach($this->_playerList as $player) {
            do{
                $numberOfDicePoints = $this->_dice->rollDice();
                LoggerService::logger()->info("Player '{$player->getPlayerIdentifier()}' rolled the dice: '{$numberOfDicePoints}'");
                $status = $this->_strategy->play($player, $numberOfDicePoints, $this->_gameBoard);

                $this->_renderer->renderScene($this, $player, $numberOfDicePoints, $roundNr);
            } while($status instanceof RediceStatus);


            if($player->isVictorious()) {
                throw new VictoryException($player);
            }
        }
    }

}