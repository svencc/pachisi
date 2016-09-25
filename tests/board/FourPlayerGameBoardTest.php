<?php
use PHPUnit\Framework\TestCase;
use \Pachisi\Collection\PlayerCollection;
use \Pachisi\Board\FourPlayerGameBoard;
use \Pachisi\GameEngine;
use \Pachisi\Area\StartArea;
use \Pachisi\Area\TargetArea;
use \Pachisi\Field\StartField;
use \Pachisi\Field\StartAreaField;
use \Pachisi\Man;
use \Pachisi\Player;

//require_once '../../config.php';
class FourPlayerGameBoardTest extends TestCase {

    /** @var  Player */
    protected $_player1;
    /** @var  Player */
    protected $_player2;
    /** @var  Player */
    protected $_player3;
    /** @var  Player */
    protected $_player4;
    /** @var  PlayerCollection */
    protected $_playerCollection;

    public function setUp() {
        // We need 4 players ...
        $this->_player1 = new \Pachisi\Player(\Pachisi\GameEngine::PLAYER_ID_1);
        $this->_player2 = new \Pachisi\Player(\Pachisi\GameEngine::PLAYER_ID_2);
        $this->_player3 = new \Pachisi\Player(\Pachisi\GameEngine::PLAYER_ID_3);
        $this->_player4 = new \Pachisi\Player(\Pachisi\GameEngine::PLAYER_ID_4);

        $this->_playerCollection = new PlayerCollection();
        $this->_playerCollection->addToCollection($this->_player1);
        $this->_playerCollection->addToCollection($this->_player2);
        $this->_playerCollection->addToCollection($this->_player3);
        $this->_playerCollection->addToCollection($this->_player4);
    }

    /**
     * Tests instantiation
     */
    public function testConstruct() {
        $board  = new FourPlayerGameBoardTestMockup($this->_playerCollection);
        $this->assertTrue(count($board->_startAreasPerPlayer) == 4);
        $this->assertTrue(count($board->_targetAreasPerPlayer) == 4);

        $expectedIndizes = array(GameEngine::PLAYER_ID_1,GameEngine::PLAYER_ID_2,GameEngine::PLAYER_ID_3,GameEngine::PLAYER_ID_4);
        foreach($board->_startAreasPerPlayer as $index => $area) {
            $this->assertTrue(in_array($index, $expectedIndizes));
            $this->assertTrue($area instanceof StartArea);
        }
        foreach($board->_targetAreasPerPlayer as $index => $area) {
            $this->assertTrue(in_array($index, $expectedIndizes));
            $this->assertTrue($area instanceof TargetArea);
        }

        $this->assertTrue($board->getPlayersStartArea($this->_player1) instanceof StartArea);
        $this->assertTrue($board->getPlayersTargetArea($this->_player1) instanceof TargetArea);
    }
    /**
     * Tests instantiation, board creation and player-board-route creation
     */
    public function testDrawPlayersRoute() {
        $board = new FourPlayerGameBoard($this->_playerCollection);

        $route2 = $board->drawPlayersRoute($this->_player2);

        $this->assertTrue($route2[0] instanceof  \Pachisi\Field\StartField);
        $this->assertTrue($route2[0]->getRelatedPlayerIdentifier() == $this->_player2->getPlayerIdentifier());

        $this->assertEquals(40, count($route2));

        $this->assertTrue($route2[39] instanceof  \Pachisi\Field\EndField);
        $this->assertTrue($route2[39]->getRelatedPlayerIdentifier() == $this->_player2->getPlayerIdentifier());
    }

    public function testCanManBeMovedForward() {
        $player1_man0 = new Man($this->_player1->getPlayerIdentifier(), 0);
        $player1_man1 = new Man($this->_player1->getPlayerIdentifier(), 1);
        $player1_man2 = new Man($this->_player1->getPlayerIdentifier(), 2);
        $player1_man3 = new Man($this->_player1->getPlayerIdentifier(), 3);

        $player2_man0 = new Man($this->_player2->getPlayerIdentifier(), 0);
        $player2_man1 = new Man($this->_player2->getPlayerIdentifier(), 1);
        $player2_man2 = new Man($this->_player2->getPlayerIdentifier(), 2);
        $player2_man3 = new Man($this->_player2->getPlayerIdentifier(), 3);


        $board = new FourPlayerGameBoardTestMockup($this->_playerCollection);
        $route2 = $board->drawPlayersRoute($this->_player2);
        $route2[2]->attachMan($player1_man0);
        $route2[4]->attachMan($player1_man1);
        $route2[37]->attachMan($player1_man2);
        $route2[39]->attachMan($player1_man3);

        $route2[1]->attachMan($player2_man0);
        $route2[3]->attachMan($player2_man1);
        $route2[36]->attachMan($player2_man2);
        $route2[38]->attachMan($player2_man3);


        $this->assertFalse($board->isManMovableForward($this->_player2,2,$player2_man0));
        $this->assertTrue($board->isManMovableForward($this->_player2,1,$player2_man0));
        $this->assertTrue($board->isManMovableForward($this->_player2,3,$player2_man0));

        $this->assertTrue($board->isManMovableForward($this->_player2,3,$player2_man3));


        $board->_targetAreasPerPlayer[$this->_player2->getPlayerIdentifier()]->attachMan(3, $player2_man0);
        $this->assertTrue($board->isManMovableForward($this->_player2,3,$player2_man3));
        $this->assertFalse($board->isManMovableForward($this->_player2,4,$player2_man3));
    }

    public function testResetManToStart() {
        $board = new FourPlayerGameBoard($this->_playerCollection);
        $startArea = $board->getPlayersStartArea($this->_player1);
        $freeMan = $startArea->getFreeMan();
        $startField = $board->getPlayersStartField($this->_player1);
        $startField->attachMan($freeMan);

        $this->assertTrue($freeMan->getCurrentPosition() instanceof StartField);
        $board->resetManToStart($freeMan);

        $this->assertTrue($freeMan->getCurrentPosition() instanceof StartAreaField);
    }
}

class FourPlayerGameBoardTestMockup extends FourPlayerGameBoard {
    /** @var  StartArea[] */
    public $_startAreasPerPlayer;
    /** @var  TargetArea[] */
    public $_targetAreasPerPlayer;
}