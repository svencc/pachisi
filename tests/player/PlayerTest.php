<?php
use PHPUnit\Framework\TestCase;
use Pachisi\Player;
use Pachisi\Man;
use Pachisi\GameEngine;
use Pachisi\Collection\ManCollection;

class PlayerTests extends TestCase {

    public function testConstruct() {
        $testPlayer = new Player(GameEngine::PLAYER_ID_1);
        $this->assertTrue(count($testPlayer->getManList()) == 4);
    }

    public function testHasManOnBoard() {
        // Player´s man are on null positions
        $testPlayer = new PlayerTestMockup(GameEngine::PLAYER_ID_1);
        $this->assertFalse($testPlayer->hasManOnBoard());

        // Player´s man are set on StartFields
        /** @var Man $man */
        foreach($testPlayer->_manCollection->iterateCollection() as $man) {
            $man->setCurrentPosition(new \Pachisi\Field\StartField($testPlayer,0));
        }
        $this->assertTrue($testPlayer->hasManOnBoard());

        // One of layer´s man is set on a RegularField
        foreach($testPlayer->_manCollection->iterateCollection() as $man) {
            $man->setCurrentPosition(new \Pachisi\Field\RegularMovementField(0));
            break;
        }
        $this->assertTrue($testPlayer->hasManOnBoard());
    }

    public function testHasManOnStartField() {
        // Player´s man are on null positions
        $testPlayer = new PlayerTestMockup(GameEngine::PLAYER_ID_1);
        $this->assertFalse($testPlayer->hasManOnStartField());

        // Player´s man are set on RegularField
        /** @var Man $man */
        foreach($testPlayer->_manCollection->iterateCollection() as $man) {
            $man->setCurrentPosition(new \Pachisi\Field\RegularMovementField(0));
        }
        $this->assertFalse($testPlayer->hasManOnStartField());

        // One of player´s man is set on a StartField
        foreach($testPlayer->_manCollection->iterateCollection() as $man) {
            $man->setCurrentPosition(new \Pachisi\Field\StartField($testPlayer,0));
            break;
        }
        $this->assertTrue($testPlayer->hasManOnStartField());
    }

    public function testGetManOnStartField() {
        // Player´s man are on null positions
        $testPlayer = new PlayerTestMockup(GameEngine::PLAYER_ID_1);

        // Player´s man are set on RegularField
        /** @var Man $man */
        foreach($testPlayer->_manCollection->iterateCollection() as $man) {
            $man->setCurrentPosition(new \Pachisi\Field\RegularMovementField(0));
        }
        $this->assertFalse($testPlayer->hasManOnStartField());

        // One of player´s man is set on a StartField
        foreach($testPlayer->_manCollection->iterateCollection() as $man) {
            $man->setCurrentPosition(new \Pachisi\Field\StartField($testPlayer,0));
            break;
        }
        $this->assertTrue($testPlayer->hasManOnStartField());
        $this->assertTrue($testPlayer->getManOnStartField() instanceof Man);
    }

    public function testGetFreeManFromStartStorageArea() {
        // Player´s man are on null positions
        $testPlayer = new PlayerTestMockup(GameEngine::PLAYER_ID_1);

        // Player´s man are set on RegularField
        /** @var Man $man */
        foreach($testPlayer->_manCollection->iterateCollection() as $man) {
            $man->setCurrentPosition(new \Pachisi\Field\RegularMovementField(0));
        }
        $this->assertFalse($testPlayer->hasManInStartArea());

        // One of player´s man is set on a StartField
        foreach($testPlayer->_manCollection->iterateCollection() as $man) {
            $man->setCurrentPosition(new \Pachisi\Field\StartAreaField($testPlayer,1));
            break;
        }
        $this->assertTrue($testPlayer->hasManInStartArea());
        $this->assertTrue($testPlayer->getOneManFromStartAreaField() instanceof Man);
    }



}

class PlayerTestMockup extends Player {
    /** @var  ManCollection */
    public $_manCollection;
}