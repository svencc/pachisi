<?php
use PHPUnit\Framework\TestCase;
use \Pachisi\Collection\PlayerCollection;
use \Pachisi\Board\FourPlayerGameBoard;
use \Pachisi\GameController;
use \Pachisi\Area\StartArea;
use \Pachisi\Area\TargetArea;

class FourPlayerGameBoardTest extends TestCase {

    /**
     * Tests instantiation
     */
    public function testConstruct() {

        // We need 4 players ...
        $player1    = new \Pachisi\Player(\Pachisi\GameController::PLAYER_ID_1);
        $player2    = new \Pachisi\Player(\Pachisi\GameController::PLAYER_ID_2);
        $player3    = new \Pachisi\Player(\Pachisi\GameController::PLAYER_ID_3);
        $player4    = new \Pachisi\Player(\Pachisi\GameController::PLAYER_ID_4);


        $playerCollection   = new PlayerCollection();
        $playerCollection->addToCollection($player1);
        $playerCollection->addToCollection($player2);
        $playerCollection->addToCollection($player3);
        $playerCollection->addToCollection($player4);

        $board  = new FourPlayerGameBoardTestMockup($playerCollection);
        $this->assertTrue(count($board->_startAreasPerPlayer) == 4);
        $this->assertTrue(count($board->_targetAreasPerPlayer) == 4);

        $expectedIndizes = array(GameController::PLAYER_ID_1,GameController::PLAYER_ID_2,GameController::PLAYER_ID_3,GameController::PLAYER_ID_4);
        foreach($board->_startAreasPerPlayer as $index => $area) {
            $this->assertTrue(in_array($index, $expectedIndizes));
            $this->assertTrue($area instanceof StartArea);
        }
        foreach($board->_targetAreasPerPlayer as $index => $area) {
            $this->assertTrue(in_array($index, $expectedIndizes));
            $this->assertTrue($area instanceof TargetArea);
        }
    }
    /**
     * Tests instantiation, board creation and player-board-route creation
     */
    public function testDrawPlayersRoute() {

        // We need 4 players ...
        $player1 = new \Pachisi\Player(\Pachisi\GameController::PLAYER_ID_1);
        $player2 = new \Pachisi\Player(\Pachisi\GameController::PLAYER_ID_2);
        $player3 = new \Pachisi\Player(\Pachisi\GameController::PLAYER_ID_3);
        $player4 = new \Pachisi\Player(\Pachisi\GameController::PLAYER_ID_4);


        $playerCollection = new PlayerCollection();
        $playerCollection->addToCollection($player1);
        $playerCollection->addToCollection($player2);
        $playerCollection->addToCollection($player3);
        $playerCollection->addToCollection($player4);

        $board = new FourPlayerGameBoard($playerCollection);

        $route2 = $board->drawPlayersRoute($player2);

        $this->assertTrue($route2[0] instanceof  \Pachisi\Field\StartField);
        $this->assertTrue($route2[0]->getRelatedPlayerIdentifier() == $player2->getIdentifier());

        $this->assertEquals(40, count($route2));

        $this->assertTrue($route2[39] instanceof  \Pachisi\Field\EndField);
        $this->assertTrue($route2[39]->getRelatedPlayerIdentifier() == $player2->getIdentifier());
    }
}

class FourPlayerGameBoardTestMockup extends FourPlayerGameBoard {
    /** @var  StartArea[] */
    public $_startAreasPerPlayer;
    /** @var  TargetArea[] */
    public $_targetAreasPerPlayer;
}