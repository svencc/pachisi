<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:31
 */

namespace Pachisi;
//use Pachisi\Game;
//use Pachisi\Player;
use Pachisi\Board\FourPlayerGameBoard;
use Pachisi\Collection\PlayerCollection;
use Pachisi\Dice\SystemDice;
use Pachisi\Strategy\StrategyComposite;
use Pachisi\Strategy\SixOutStrategy;
use Pachisi\Strategy\ClearStartFieldStrategy;
use Pachisi\Strategy\BringManToTargetAreaStrategy;
use Pachisi\Strategy\GoOnWithManStrategy;

class GameFactory {

    public static function setup4PlayersGame() {

        $game = new GameController();

        // We need a dice
        $dice   = new SystemDice();
        $game->addDice($dice);

        // We need 4 players ...
        $player1    = new Player(GameController::PLAYER_ID_1);
        $player2    = new Player(GameController::PLAYER_ID_2);
        $player3    = new Player(GameController::PLAYER_ID_3);
        $player4    = new Player(GameController::PLAYER_ID_4);

        $playerCollection   = new PlayerCollection();
        $playerCollection->addToCollection($player1);
        $playerCollection->addToCollection($player2);
        $playerCollection->addToCollection($player3);
        $playerCollection->addToCollection($player4);

        // ... and add them to the game
        $game->addPlayers($playerCollection);

        // We also need a game board
        $gameBoard = new FourPlayerGameBoard($playerCollection);
        $game->addBoard($gameBoard);

        $strategies = new StrategyComposite();
        $strategies->combineStrategy(new ClearStartFieldStrategy());
        $strategies->combineStrategy(new SixOutStrategy());
        $strategies->combineStrategy(new ClearStartFieldStrategy());
        $strategies->combineStrategy(new BringManToTargetAreaStrategy());
        $strategies->combineStrategy(new GoOnWithManStrategy());
        $game->addStrategy($strategies);

    }

}