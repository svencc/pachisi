<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 20:24
 */

namespace Pachisi\Board;
use Pachisi\Collection\PlayerCollection;
use Pachisi\Field\Exception\FieldIsNotEmptyException;
use Pachisi\Field\StartAreaField;
use Pachisi\Field\TargetAreaField;
use Pachisi\Man;
use Pachisi\Player;

use Pachisi\Field\FieldAbstract;
use Pachisi\Field\RegularMovementField;
use Pachisi\Field\StartField;
use Pachisi\Field\EndField;

use Pachisi\Area\StartArea;
use Pachisi\Area\TargetArea;
use Pachisi\Logger\LoggerService;

abstract class GameBoardAbstract {

    /**
     * @var FieldAbstract[]
     */
    protected $_circuitFieldList = array();

    /** @var StartArea[] */
    protected $_startAreasPerPlayer = array();

    /** @var TargetArea[] */
    protected $_targetAreasPerPlayer = array();

    /**
     * GameBoardAbstract constructor.
     *
     * @param   PlayerCollection $collection
     */
    public function __construct(PlayerCollection $collection) {
        /** @var Player $player */
        foreach ($collection->iterateCollection() as $player) {
            $this->_startAreasPerPlayer[$player->getPlayerIdentifier()] = new StartArea($player);
            foreach ($player->getManList() as $man) {
                $this->resetManToStart($man);
            }
            $this->_targetAreasPerPlayer[$player->getPlayerIdentifier()] = new TargetArea($player);
        }

        $this->_circuitFieldList = $this->_createCircuit($collection);
    }


    public function isManMovableForward(Player $player, $numberOfDicePoints, Man $man) {
        $fieldToMove = $this->getFieldToMove($player, $numberOfDicePoints, $man);
        if ($fieldToMove instanceof FieldAbstract) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Checks if the Player´s man is able to move forward $numberOfDicePoints
     *
     * @param Player $player
     * @param        $numberOfDicePoints
     * @param Man    $man
     *
     * @return bool|FieldAbstract
     */
    public function getFieldToMove(Player $player, $numberOfDicePoints, Man $man) {
        $currentPosition = $man->getCurrentPosition();
        $route = $this->drawPlayersRoute($player);

        $remainingDicePoints = $numberOfDicePoints;
        $manPositionFound = FALSE;
        $endFieldOfMovement = NULL;
        // Iterate over the hole route
        foreach ($route as $field) {
            // if the position of man was found we begin to count down the remaining dice points
            if ($manPositionFound) {
                $remainingDicePoints--;
                // in case the remainingDicePoints are 9, we know that the movement stops on the route...
                if ($remainingDicePoints == 0) {
                    $endFieldOfMovement = $field;
                    // ... and we stop the iteration here!
                    break;
                }
            }
            // if the currentPosition (of man) is equal with the current iterations field, we found the position on
            // the route
            if (spl_object_hash($field) == spl_object_hash($currentPosition)) {
                $manPositionFound = TRUE;
            }
        }

        // If the endFieldOfMovement is on the track, we have to check the track if there is another man ...
        if ($endFieldOfMovement instanceof FieldAbstract) {
            if ($endFieldOfMovement->hasMan()) {
                $occupingMan = $endFieldOfMovement->getMan();
                // .. if there is a man, we have to check if it belongs to our player or not ...
                if ($occupingMan->getPlayerIdentifier() == $player->getPlayerIdentifier()) {
                    // .. in case the man belongs to our player we are not able to move
                    return FALSE;
                } else {
                    // .. in case the man belongs to an other player we are able to move
                    return $endFieldOfMovement;
                }
                // if there is no man, we are able to move here in any case!
            } else {
                return $endFieldOfMovement;
            }

            // In case, the movement did not stop on the route, we have to check if we are allowed move into the TargetArea
        } else {
            $playersTargetArea = $this->getPlayersTargetArea($player);
//            var_dump($playersTargetArea);
            if ($playersTargetArea->isFieldAccessible($currentPosition, $remainingDicePoints)) {
                return $playersTargetArea->getField($remainingDicePoints);
            }
        }
    }

    public function moveToField(Player $player, FieldAbstract $fieldToMove, Man $man) {
        if($fieldToMove->hasMan()) {
            if ($man->getPlayerIdentifier() == $fieldToMove->getMan()->getPlayerIdentifier()) {
                throw new FieldIsNotEmptyException('On the given field is a man of the same player!');
            }
        }

        $man->getCurrentPosition()->detachMan();
        if($fieldToMove->hasMan()) {
            $manToEliminate = $fieldToMove->getMan();
            $fieldToMove->detachMan();
            $this->resetManToStart($manToEliminate);
        }
        $fieldToMove->attachMan($man);
    }

    /**
     * Template Method Pattern
     *
     * Forces to implement the number of fields per player in inhereted classes
     *
     * @return integer
     */
    abstract protected function _fieldsPerPlayer();

    /**
     * @param   PlayerCollection $collection
     *
     * @return FieldAbstract[]
     */
    protected function _createCircuit(PlayerCollection $collection) {
        /** @var FieldAbstract[] $circuitFields */
        $circuitFields = array();
        $regularFields = $this->_fieldsPerPlayer();

        $playersInEndFieldOrder = clone $collection;
        $playersInEndFieldOrder->leftShiftContent();

        $fieldNr = 0;
        foreach ($collection->iterateCollection() as $player) {

            // We begin with creating the StartField ...
            $circuitFields[] = new StartField($player, $fieldNr);

            // ... than we add n fields till the next start field will be inserted
            for ($iteration = 0; $iteration < $regularFields - 2; $iteration++) {
                $fieldNr++;
                $circuitFields[] = new RegularMovementField($fieldNr);
            }
            $fieldNr++;
            // We finish the iteration with creating the EndField for the player before...
            $circuitFields[] = new EndField($playersInEndFieldOrder->shiftFirstItemFromCollection() ,$fieldNr);
            $fieldNr++;
        }

        return $circuitFields;
    }

    /**
     * Draws for every given player his own route from StartField to EndField
     *
     * @param Player $player The player which should be used to generate his personal route
     *
     * @return FieldAbstract[]
     */
    public function drawPlayersRoute(Player $player) {
        $line = array();
        $startFoundFlag = FALSE;
        /** @var FieldAbstract $field */
        foreach ($this->_itearateCircuit() as $field) {

            // First we look for the players start field
            if ($field instanceof StartField) {
                if ($field->getRelatedPlayerIdentifier() == $player->getPlayerIdentifier()) {
                    $startFoundFlag = TRUE;
                }
            }

            // If we found the players start field, we track each field until we find his EndField
            if ($startFoundFlag) {
                $line[] = $field;
                if ($field instanceof EndField) {
                    if ($field->getRelatedPlayerIdentifier() == $player->getPlayerIdentifier()) {
                        break;
                    }
                }
            }
        }

        return $line;
    }

    /**
     * @param Player $player
     *
     * @return Man[]
     */
    public function getPlayersManWithAscendingDistanzToEndField(Player $player) {
        $orderedManList = array();
        $route = $this->drawPlayersRoute($player);
        /** @var FieldAbstract[] $reverseRoute */
        $reverseRoute = array_reverse ($route);
        foreach($reverseRoute as $field) {
            if($field->hasMan() && $field->getMan()->getPlayerIdentifier() == $player->getPlayerIdentifier()) {
                $orderedManList[] = $field->getMan();
            }
        }

        return $orderedManList;
    }

    /**
     * @return \Generator[FieldAbstract]
     */
    public function _itearateCircuit() {
        $circuitLength = $this->getCircuitLength();
        $iteration = 0;

        do {
            yield $this->_circuitFieldList[$iteration];
            $iteration++;
            if ($iteration == $circuitLength) {
                $iteration = 0;
            }
        } while (TRUE);
    }


    /**
     * @param Player $player
     *
     * @return StartField
     */
    public function getPlayersStartField(Player $player) {
        $route = $this->drawPlayersRoute($player);
        return array_shift($route);
    }

    /**
     * @param Player $player
     *
     * @return EndField
     */
    public function getPlayersEndField(Player $player) {
        $route = $this->drawPlayersRoute($player);
        return array_pop($route);
    }

    /**
     * @param Player|string $player
     *
     * @return StartArea
     */
    public function getPlayersStartArea($player) {
        if($player instanceof Player) {
            $playerIdentifier = $player->getPlayerIdentifier();
        } else {
            $playerIdentifier = $player;
        }
        return $this->_startAreasPerPlayer[$playerIdentifier];
    }

    /**
     * @param Player|string $player
     *
     * @return TargetArea
     */
    public function getPlayersTargetArea(Player $player) {
        if($player instanceof Player) {
            $playerIdentifier = $player->getPlayerIdentifier();
        } else {
            $playerIdentifier = $player;
        }
        return $this->_targetAreasPerPlayer[$playerIdentifier];
    }

    /**
     * @param Player $player
     *
     * @return TargetArea
     */
    public function appendToPlayersTargetArea(Player $player, TargetAreaField $targetAreaField) {
        return $this->_targetAreasPerPlayer[$player->getPlayerIdentifier()] = $targetAreaField;
    }

    /**
     * @param Player $player
     *
     * @return StartArea
     */
    public function appendToPlayersStartArea(Player $player, StartAreaField $startAreaField) {
        return $this->_startAreasPerPlayer[$player->getPlayerIdentifier()] = $startAreaField;
    }

    /**
     * @param $manToEliminate
     */
    public function resetManToStart(Man $manToEliminate) {
        $startArea = $this->getPlayersStartArea($manToEliminate->getPlayerIdentifier());
        $startArea->resetManToStart($manToEliminate);
        LoggerService::logger()->info("KICK OUT :{$manToEliminate->getManIdentifier()}!");
    }

    /**
     * @return int
     */
    public function getCircuitLength() {
        $circuitLength = count($this->_circuitFieldList);

        return $circuitLength;
    }
}