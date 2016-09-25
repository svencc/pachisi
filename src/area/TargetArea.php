<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:23
 */

namespace Pachisi\Area;
use Pachisi\Area\Exception\AreaIsEmptyException;
use Pachisi\Field\FieldAbstract;
use Pachisi\Man;
use Pachisi\Player;
use Pachisi\Field\TargetAreaField;
use Pachisi\Validator\ValidatorService;
use \Pachisi\Validator\Exception\OutOfRangeException;

class TargetArea extends AreaAbstract {

    public function isFieldEmpty($fieldNr) {
        ValidatorService::_validateRange(1,4,$fieldNr);
        return !$this->_fieldList[$fieldNr-1]->hasMan();
    }

    public function getField($fieldNr) {
        return $this->_fieldList[$fieldNr-1];
    }

//todo: unit test
    /**
     * @return Man[]
     * @throws AreaIsEmptyException
     */
    public function getManListFirstToLast(){
        /** @var Man[] $orderedList */
        $orderedList = array();
        for($iteration=3; $iteration>=0;$iteration--) {
            if ($this->_fieldList[$iteration]->hasMan()) {
                $orderedList[] = $this->_fieldList[$iteration]->getMan();
            }
        }

        return $orderedList;
    }

    public function isFieldAccessible(FieldAbstract $fromField, $targetFieldNr) {
        try {
            ValidatorService::_validateRange(1,4,$targetFieldNr);
        } catch (OutOfRangeException $oore) {
            return false;
        }

        if($fromField instanceof TargetAreaField) {
            $fromFieldNr = $fromField->getFieldNr();
            $fieldToCheck = $fromFieldNr+1;
            if($fieldToCheck > $targetFieldNr) {
                return false;
            }
            for($fieldToCheck; $fieldToCheck<=$targetFieldNr; $fieldToCheck++) {
                if(!$this->isFieldEmpty($fieldToCheck)) {
                    return false;
                }
            }

            return true;

        } else {
            $fromFieldNr = 0;
            $fieldToCheck = $fromFieldNr+1;
            if($fieldToCheck > $targetFieldNr) {
                return false;
            }
            for($fieldToCheck; $fieldToCheck<=$targetFieldNr; $fieldToCheck++) {
                if(!$this->isFieldEmpty($fieldToCheck)) {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * @param $fieldNr
     * @param Man $man
     */
    public function attachMan($fieldNr, Man $man) {
        if($this->isFieldEmpty($fieldNr)) {
            $fieldNr-1;
            $this->_fieldList[$fieldNr-1]->attachMan($man);
        }
    }

    public function detachMan($fieldNr, $man) {
        if($this->isFieldEmpty($fieldNr-1)) {
            return $this->_fieldList[$fieldNr-1]->detachMan($man);
        }
    }

    /**
     * @param Player $player
     *
     * @return TargetAreaField[]
     */
    protected function _initFields(Player $player) {
        return array(
            new TargetAreaField($player,1),
            new TargetAreaField($player,2),
            new TargetAreaField($player,3),
            new TargetAreaField($player,4),
        );
    }

}