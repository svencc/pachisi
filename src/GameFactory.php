<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:31
 */

namespace Pachisi;
use Pachisi\Game;
use Pachisi\Player;
use Pachisi\Board\FourPlayerGameBoard;

class GameFactory {

    public static function setup4PlayersGame() {

        $game = new Game();

        // We need a dice
        $dice   = new Dice();
        $game->addDice($dice);

        // We need 4 players ...
        $player1    = new Player(GAME::PLAYER_ID_1);
        $player2    = new Player(GAME::PLAYER_ID_2);
        $player3    = new Player(GAME::PLAYER_ID_3);
        $player4    = new Player(GAME::PLAYER_ID_4);

        // ... and add them to the game
        $game->addPlayer($player1);
        $game->addPlayer($player2);
        $game->addPlayer($player3);
        $game->addPlayer($player4);

        // Each player needs to bring his 4 men to the game
        $game->addMen($player1->getManList());
        $game->addMen($player2->getManList());
        $game->addMen($player3->getManList());
        $game->addMen($player4->getManList());

        // We also need a game board
        $gameBoard = new FourPlayerGameBoard();

    }

}