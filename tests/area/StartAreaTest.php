<?php
use PHPUnit\Framework\TestCase;
use \Pachisi\Man;
use \Pachisi\Area\StartArea;
use \Pachisi\Player;
use \Pachisi\Field\StartField;
use \Pachisi\Field\FieldAbstract;

class StartAreaTests extends TestCase {

    /** @var  Player */
    protected $_testPlayer1;
    /** @var  Man */
    protected $_testMan1;
    /** @var  Man */
    protected $_testMan2;
    /** @var  Man */
    protected $_testMan3;
    /** @var  Man */
    protected $_testMan4;

    public function setUp() {
        $this->_testPlayer1 = new Player('id1');
        $this->_testMan1 = new Man('id1', 0);
        $this->_testMan2 = new Man('id1', 1);
        $this->_testMan3 = new Man('id1', 2);
        $this->_testMan4 = new Man('id1', 3);
    }

    public function testConstruct() {
        $testMockup = new StartAreaTestMockup($this->_testPlayer1);
        $this->assertTrue(count($testMockup->_fieldList) == 4);
        foreach($testMockup->_fieldList as $field) {
            $this->assertTrue($field instanceof StartField);
        }
        $this->assertTrue($testMockup->_playerIdentifier == 'id1');
    }

    public function testGetFreeManOnEmptyArea() {
        $testMockup = new StartAreaTestMockup($this->_testPlayer1);
        $this->expectException('\Pachisi\Area\Exception\AreaIsEmptyException');
        $testMockup->getFreeMan();
    }

    public function testGetFreeMan() {
        $testMockup = new StartAreaTestMockup($this->_testPlayer1);
        /** @var StartField $startField */
        $startField = $testMockup->_fieldList[3];
        $startField->attachMan($this->_testMan1);
        $this->assertEquals($this->_testMan1, $testMockup->getFreeMan());
    }

    public function testResetManToStart() {
        $testMockup = new StartAreaTestMockup($this->_testPlayer1);
        $testMockup->_fieldList[0]->attachMan($this->_testMan1);
        $testMockup->_fieldList[1]->attachMan($this->_testMan2);
        $this->assertFalse($testMockup->_fieldList[2]->hasMan());
        $testMockup->_fieldList[3]->attachMan($this->_testMan4);
        $testMockup->resetManToStart($this->_testMan3);

        $this->assertTrue($testMockup->_fieldList[2]->hasMan());
    }
}

class StartAreaTestMockup extends StartArea  {
    /** @var string */
    public $_playerIdentifier;
    /** @var FieldAbstract[] */
    public $_fieldList;
}
