<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 20:24
 */

namespace Pachisi\Board;
use Pachisi\Collection\PlayerCollection;
use Pachisi\Field\PlayerRelatedField;
use Pachisi\Player;

use Pachisi\Field\FieldAbstract;
use Pachisi\Field\RegularField;
use Pachisi\Field\StartField;
use Pachisi\Field\EndField;

use Pachisi\Area\StartArea;
use Pachisi\Area\TargetArea;

abstract class GameBoardAbstract {

    /**
     * @var FieldAbstract[]
     */
    protected $_circuitFieldList = array();

    /** @var StartArea[]  */
    protected $_startAreasPerPlayer = array();

    /** @var TargetArea[]  */
    protected $_targetAreasPerPlayer = array();

    /**
     * GameBoardAbstract constructor.
     *
     * @param   PlayerCollection    $players
     */
    public function __construct(PlayerCollection $collection) {
        /** @var Player $player */
        foreach($collection->iterateCollection() as $player) {
            $this->_startAreasPerPlayer[$player->getUID()] = new StartArea($player);
            foreach($player->getManList() as $man) {
                $this->_startAreasPerPlayer[$player->getUID()]->resetManToStart($man);
            }
            $this->_targetAreasPerPlayer[$player->getUID()] = new TargetArea($player);
        }

        $this->_circuitFieldList = $this->_createCircuit($collection);
    }

    /**
     * @param   PlayerCollection $collection
     *
     * @return FieldAbstract[]
     */
    protected function _createCircuit(PlayerCollection $collection) {
        /** @var FieldAbstract[] $circuitFields */
        $circuitFields  = array();
        $regularFields  = $this->_fieldsPerPlayer();

        $playersInEndFieldOrder  = clone $collection;
        $playersInEndFieldOrder->leftShiftContent();

        foreach ($collection->iterateCollection() as $player) {

            // We begin with creating the StartField ...
            $circuitFields[] = new StartField($player);

            // ... than we add n fields till the next start field will be inserted
            for($iteration=0; $iteration < $regularFields-2; $iteration++) {
                $circuitFields[] = new RegularField($player);
            }

            // We finish the iteration with creating the EndField for the player before...
            $circuitFields[] = new EndField($playersInEndFieldOrder->shiftFirstItemFromCollection());
        }

        return $circuitFields;
    }

    /**
     * Draws for every given player his own route from StartField to EndField
     *
     * @param Player $player The player which should be used to generate his personal route
     *
     * @return PlayerRelatedField[]
     */
    public function drawPlayersRoute(Player $player) {
        $line   = array();
        $startFoundFlag = false;
        /** @var FieldAbstract $field */
        foreach($this->_itearateCircuit() as $field) {

            // First we look for the players start field
            if($field instanceof StartField) {
                if( $field->getRelatedPlayerIdentifier() == $player->getIdentifier() ) {
                    $startFoundFlag = true;
                }
            }

            // If we found the players start field, we track each field until we find his EndField
            if($startFoundFlag) {
                $line[] = $field;
                if($field instanceof EndField) {
                    if( $field->getRelatedPlayerIdentifier() == $player->getIdentifier() ) {
                        break;
                    }
                }
            }
        }

        return $line;
    }

    /**
     * @return \Generator
     */
    protected function _itearateCircuit() {
        $circuitLength  = count($this->_circuitFieldList);
        $iteration      = 0;

        do {
            yield $this->_circuitFieldList[$iteration];
            $iteration++;
            if ($iteration == $circuitLength) {
                $iteration = 0;
            }
        } while(true);
    }

    /**
     * Template Method Pattern
     *
     * Forces to implement the number of fields per player in inhereted classes
     *
     * @return integer
     */
    abstract protected function _fieldsPerPlayer();
}