<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:31
 */

namespace Pachisi;
use Pachisi\Board\FourPlayerGameBoard;
use Pachisi\Collection\PlayerCollection;
use Pachisi\Dice\RandomOrgDice;
use Pachisi\Dice\SystemDice;
use Pachisi\Strategy\MoveManForwardInTargetAreaStrategy;
use Pachisi\Strategy\EndTurnStrategy;
use Pachisi\Strategy\StrategyComposite;
use Pachisi\Strategy\SixOutStrategy;
use Pachisi\Strategy\ClearStartFieldStrategy;
use Pachisi\Strategy\BringManInTargetAreaStrategy;
use Pachisi\Strategy\MoveManForwardOnBoardStrategy;

class GameFactory {


    /**
     * @return GameEngine
     */
    public static function setup4PlayersGame() {

        $gameEngine = new GameEngine();

        // We need a dice
        if(USE_RANDOMORG_API === true) {
            $dice = new RandomOrgDice(RANDOMORG_API_KEY);
            \Pachisi\Logger\LoggerService::registerNewServiceConsumer($dice);
        } else {
            $dice = new SystemDice();
        }
        $gameEngine->addDice($dice);

        // We need 4 players ...
        $player1    = new Player(GameEngine::PLAYER_ID_1);
        $player2    = new Player(GameEngine::PLAYER_ID_2);
        $player3    = new Player(GameEngine::PLAYER_ID_3);
        $player4    = new Player(GameEngine::PLAYER_ID_4);

        $playerCollection   = new PlayerCollection();
        $playerCollection->addToCollection($player1);
        $playerCollection->addToCollection($player2);
        $playerCollection->addToCollection($player3);
        $playerCollection->addToCollection($player4);

        // ... and add them to the game
        $gameEngine->addPlayers($playerCollection);

        // We also need a game board
        $gameBoard = new FourPlayerGameBoard($playerCollection);
        $gameEngine->addBoard($gameBoard);

        $strategies = new StrategyComposite();
//        $strategies->queueStrategy(new ClearStartFieldStrategy());
        $strategies->queueStrategy(new SixOutStrategy());
        $strategies->queueStrategy(new ClearStartFieldStrategy());
        $strategies->queueStrategy(new BringManInTargetAreaStrategy()); //todo
        $strategies->queueStrategy(new MoveManForwardInTargetAreaStrategy());
        $strategies->queueStrategy(new MoveManForwardOnBoardStrategy());
        $strategies->queueStrategy(new EndTurnStrategy());
        $gameEngine->addStrategy($strategies);

        $renderer = new Renderer(RENDER_LOG_FILE);
        $gameEngine->addRenderer($renderer);

        return $gameEngine;
    }

}