<?php
use PHPUnit\Framework\TestCase;

class FourPlayerGameBoardTests extends TestCase {
    // ...

    public function testCanBeNegated() {

        // We need 4 players ...
        $player1    = new \Pachisi\Player(\Pachisi\Game::PLAYER_ID_1);
        $player2    = new \Pachisi\Player(\Pachisi\Game::PLAYER_ID_2);
        $player3    = new \Pachisi\Player(\Pachisi\Game::PLAYER_ID_3);
        $player4    = new \Pachisi\Player(\Pachisi\Game::PLAYER_ID_4);

        $allPlayers = array(
            $player1,
            $player2,
            $player3,
            $player4
        );

        $board  = new \Pachisi\Board\FourPlayerGameBoard($allPlayers);
        $route2  = $board->drawPlayersRoute($player2);

        $this->assertTrue($route2[0] instanceof  \Pachisi\Field\StartField);
        $this->assertTrue($route2[0]->getRelatedPlayerIdentifier() == $player2->getIdentifier());

        $this->assertEquals(40, count($route2));

        $this->assertTrue($route2[39] instanceof  \Pachisi\Field\EndField);
        $this->assertTrue($route2[39]->getRelatedPlayerIdentifier() == $player2->getIdentifier());
    }
}
