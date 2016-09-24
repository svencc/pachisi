<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 20:24
 */

namespace Pachisi\Board;
use Pachisi\Player;

use Pachisi\Field\FieldAbstract;
use Pachisi\Field\RegularField;
use Pachisi\Field\StartField;
use Pachisi\Field\EndField;

abstract class GameBoardAbstract {

    /**
     * @var FieldAbstract[]
     */
    protected $_circuitFieldList = array();

    protected $_startAreaList;


    /**
     * GameBoardAbstract constructor.
     *
     * @param   Player[]    $players
     */
    public function __construct($players) {
        foreach($players as $player) {
            $this->_setupPlayersEquipment($player);
        }

        $this->_circuitFieldList = $this->_createCircuit($players);
    }

    protected function _setupPlayersEquipment(Player $player) {
        $this->_playerList[$player->getIdentifier()] = $player->getManList();
    }


    /**
     * @param   Player[]  $players
     * @return FieldAbstract[]
     */
    protected function _createCircuit($players) {
        /** @var FieldAbstract[] $circuitFields */
        $circuitFields  = array();
        $regularFields  = $this->_fieldsPerPlayer();

        $playerInEndFieldOrder  = $players;
        $firstPlayer            = array_shift($playerInEndFieldOrder);
        array_push($playerInEndFieldOrder, $firstPlayer);

        foreach($players as $player) {
            // We begin with creating the StartField ...
            $circuitFields[] = new StartField($player);
            // ... than we add n fields till the next start field will be inserted
            for($iteration=0; $iteration < $regularFields-2; $iteration++) {
                $circuitFields[] = new RegularField($player);
            }

            // We finish the iteration with creating the EndField for the player before...
            $circuitFields[] = new EndField(array_shift($playerInEndFieldOrder));
        }

        return $circuitFields;
    }

    /**
     * Draws for every given player his own route from StartField to EndField
     *
     * @param Player $player The player which should be used to generate his personal route
     *
     * @return array
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