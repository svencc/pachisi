<?php
use PHPUnit\Framework\TestCase;
use \Pachisi\Man;
use \Pachisi\Area\TargetArea;
use \Pachisi\Player;
use \Pachisi\Field\TargetAreaField;
use \Pachisi\Field\FieldAbstract;

class TargetAreaTests extends TestCase {

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
        $testMockup = new TargetAreaTestMockup($this->_testPlayer1);
        $this->assertTrue(count($testMockup->_fieldList) == 4);
        foreach($testMockup->_fieldList as $field) {
            $this->assertTrue($field instanceof TargetAreaField);
        }
        $this->assertTrue($testMockup->_playerIdentifier == 'id1');
    }

    public function testIsFieldEmptyOutOfFieldRange() {
        $testMockup = new TargetAreaTestMockup($this->_testPlayer1);

        $this->expectException('\Pachisi\Validator\Exception\OutOfRangeException');
        $testMockup->isFieldEmpty(5);
    }
    public function testIsFieldEmpty() {
        $testMockup = new TargetAreaTestMockup($this->_testPlayer1);
        $this->assertTrue($testMockup->isFieldEmpty(3));
        $testMockup->_fieldList[2]->attachMan($this->_testMan1);
        $this->assertFalse($testMockup->isFieldEmpty(3));
    }

    public function testIsFieldAccessible() {
        $testMockup = new TargetAreaTestMockup($this->_testPlayer1);
        $testMockup->_fieldList[3]->attachMan($this->_testMan1);
        $this->assertFalse($testMockup->isFieldAccessible($testMockup->_fieldList[0],1));
        $this->assertTrue($testMockup->isFieldAccessible($testMockup->_fieldList[0],2));
        $this->assertTrue($testMockup->isFieldAccessible($testMockup->_fieldList[0],3));
        $this->assertFalse($testMockup->isFieldAccessible($testMockup->_fieldList[0],4));

        unset($testMockup);

        $testMockup = new TargetAreaTestMockup($this->_testPlayer1);
        $this->assertTrue($testMockup->isFieldAccessible($testMockup->_fieldList[0],3));
        $testMockup->_fieldList[0]->attachMan($this->_testMan1);
        $testMockup->_fieldList[1]->attachMan($this->_testMan2);
        $this->assertFalse($testMockup->isFieldAccessible($testMockup->_fieldList[0],1));
        $this->assertFalse($testMockup->isFieldAccessible($testMockup->_fieldList[0],2));
        $this->assertFalse($testMockup->isFieldAccessible($testMockup->_fieldList[0],3));
        $this->assertFalse($testMockup->isFieldAccessible($testMockup->_fieldList[0],4));
        $this->assertTrue($testMockup->isFieldAccessible($testMockup->_fieldList[1],4));

        unset($testMockup);

        $testMockup = new TargetAreaTestMockup($this->_testPlayer1);
        $testMockup->_fieldList[2]->attachMan($this->_testMan1);
        $this->assertTrue($testMockup->isFieldAccessible(new \Pachisi\Field\RegularMovementField(1),1));
        $this->assertTrue($testMockup->isFieldAccessible(new \Pachisi\Field\RegularMovementField(1),2));
        $this->assertFalse($testMockup->isFieldAccessible(new \Pachisi\Field\RegularMovementField(1),3));
        $this->assertFalse($testMockup->isFieldAccessible(new \Pachisi\Field\RegularMovementField(1),4));
    }

    public function testGetManListFirstToLast() {
        $testMockup = new TargetAreaTestMockup($this->_testPlayer1);
        $testMockup->_fieldList[0]->attachMan($this->_testMan1);
        $testMockup->_fieldList[2]->attachMan($this->_testMan2);
        $manList = $testMockup->getManListFirstToLast();
        $this->assertTrue(count($manList) == 2);
        $this->assertTrue($manList[0] == $this->_testMan2);
        $this->assertTrue($manList[1] == $this->_testMan1);
    }


}

class TargetAreaTestMockup extends TargetArea  {
    /** @var  string */
    public $_playerIdentifier;
    /** @var  FieldAbstract[] */
    public $_fieldList;
}
