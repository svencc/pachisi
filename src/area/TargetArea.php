<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:23
 */

namespace Pachisi\Area;
use Pachisi\Player;
use Pachisi\Field\TargetField;
use Pachisi\Validator\Validator;

class TargetArea extends AreaAbstract {

    public function isFieldEmpty($fieldNr) {
        Validator::_validateRange(1,4,$fieldNr);

        return !$this->_fieldList[$fieldNr-1]->hasMan();
    }

    public function isFieldAccessible($fieldNr) {
        $fieldIndexToCheck = $fieldNr-1;

        foreach($this->_fieldList as $index => $field) {
            if($index == ($fieldIndexToCheck)) {
                break;
            }

            if ($field->hasMan()) {
                return false;
            }
        }

        return !$this->_fieldList[$fieldIndexToCheck]->hasMan();
    }

    /**
     * @param Player $player
     *
     * @return TargetField[]
     */
    protected function _initFields(Player $player) {
        return array(
            new TargetField($player),
            new TargetField($player),
            new TargetField($player),
            new TargetField($player),
        );
    }

}