<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 20:24
 */

namespace Pachisi\Board;


class FourPlayerGameBoard extends GameBoardAbstract {

    /**
     * Template Method Pattern
     *
     * Forces to implement the number of fields per player in inhereted classes
     *
     * @return integer
     */
    protected function _fieldsPerPlayer() {
        return 10;
    }
}