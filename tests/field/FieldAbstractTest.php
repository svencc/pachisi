<?php
use PHPUnit\Framework\TestCase;
use \Pachisi\Field\FieldAbstract;
use \Pachisi\Man;

class FieldAbstractTests extends TestCase {

    /** @var  Man */
    protected $_testMan2;
    /** @var  Man */
    protected $_testMan1;

    public function  setUp(){
        $this->_testMan1 = new Man('id1', 1);
        $this->_testMan2 = new Man('id1', 2);
    }



    public function testHasManNegative() {
        $mockupField = new FieldAbstractTestMockup(0);
        $this->assertFalse($mockupField->hasMan());
    }

    public function testHasManPositive() {
        $mockupField = new FieldAbstractTestMockup(0);
        $mockupField->_man = $this->_testMan1;
        $this->assertTrue($mockupField->hasMan());
    }



    public function testAttachManToEmptyField() {
        $mockupField = new FieldAbstractTestMockup(0);
        $mockupField->attachMan($this->_testMan1);
        $this->assertEquals($this->_testMan1, $mockupField->_man);
    }

    public function testAttachManOnOccupiedField() {
        $mockupField = new FieldAbstractTestMockup(0);
        $mockupField->_man = $this->_testMan1;
        $this->expectException('\Pachisi\Field\Exception\FieldIsNotEmptyException');
        $mockupField->attachMan($this->_testMan2);
    }



    public function testDetachManFromOccupiedField() {
        $mockupField = new FieldAbstractTestMockup(0);
        $mockupField->_man = $this->_testMan1;
        $this->assertEquals($this->_testMan1, $mockupField->detachMan());
    }

    public function testDetachManFromEmptyField() {
        $mockupField = new FieldAbstractTestMockup(0);
        $this->expectException('\Pachisi\Field\Exception\FieldIsEmptyException');
        $mockupField->detachMan();
    }

}

class FieldAbstractTestMockup extends FieldAbstract {
    // Overwrite visibility
    public $_man;
}
