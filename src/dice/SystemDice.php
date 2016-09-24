<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:24
 */

namespace Pachisi\Dice;


class SystemDice extends DiceAbstract {

    public function rollDice() {
        return rand(1,6);
    }
}