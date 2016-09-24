<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:23
 */

namespace Pachisi\Area;
use Pachisi\Area\Exception\AreaIsEmptyException;
use Pachisi\Area\Exception\AreaOverflowException;
use Pachisi\Man;
use Pachisi\Player;
use Pachisi\Field\StartStorageField;


/**
 * Class StartArea
 * @package Pachisi\Area
 */
class StartArea extends AreaAbstract {

    /**
     * @return \Pachisi\Man
     * @throws AreaIsEmptyException
     */
    public function getFreeMan() {
        foreach($this->_fieldList as $field) {
            if($field->hasMan()) {
                return $field->detachMan();
            }
        }

        Throw new AreaIsEmptyException();
    }

    /**^
     * @param Man $man
     *
     * @throws AreaOverflowException
     */
    public function resetManToStart(Man $man) {
        foreach($this->_fieldList as $field) {
            if($field->hasMan() == false) {
                return $field->attachMan($man);
            }
        }

        Throw new AreaOverflowException();
    }

    /**
     * @param Player $player
     *
     * @return StartStorageField[]
     */
    protected function _initFields(Player $player) {
        return array(
            new StartStorageField($player),
            new StartStorageField($player),
            new StartStorageField($player),
            new StartStorageField($player)
        );
    }

}