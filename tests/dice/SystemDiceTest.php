<?php
use PHPUnit\Framework\TestCase;
use Pachisi\Dice\SystemDice;

class SystemDiceTests extends TestCase {

    public function testRollDice() {
        $testDice = new Pachisi\Dice\SystemDice();

        $allResults = array();
        for($iteration=0; $iteration<= 9999; $iteration++) {
            $number = $testDice->rollDice();
            $allResults[] = $number;
            $this->assertTrue($this->_testInRange($number));
        }

        $distribution = array_count_values($allResults);
        $this->assertTrue(count($distribution) == 6);

    }

    protected function _testInRange($number) {
        if(1 <= $number && $number <= 6) {
            return true;
        } else {
            return false;
        }
    }

}