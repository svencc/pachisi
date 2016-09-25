<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 25.09.2016
 * Time: 19:12
 */

namespace Pachisi;


use Pachisi\Board\GameBoardAbstract;
use Pachisi\Field\EndField;
use Pachisi\Field\FieldAbstract;
use Pachisi\Field\StartField;

class Renderer {

    private $_renderLogResource;
    private $pathToRenderLog;

    public function __construct($pathToRenderLog) {
        $this->pathToRenderLog = $pathToRenderLog;
        $this->_renderLogResource = fopen(RENDER_LOG_FILE, 'w' );
        fclose($this->_renderLogResource);
    }

    CONST EMPTY_FIELD = 'o';

    public function renderScene(GameEngine $engine, Player $player, $numberOfDicePoints, $roundNr ) {
        $headLine = "Round: {$roundNr} | Player: {$player->getPlayerIdentifier()} | Dice: {$numberOfDicePoints}";
        $circuit = $this->_renderCircuit($engine->getBoard());
        $area = $this->_renderAreas($engine);

        $output = ("\n{$headLine}\n{$circuit}\n{$area}\n");;
        echo $output;

        file_put_contents($this->pathToRenderLog,$output,FILE_APPEND);
    }

    protected function _renderAreas(GameEngine $engine) {
        $areas = '';

        foreach($engine->getPlayers() as $player) {
            $startArea = '';
            $startFields = $engine->getBoard()->getPlayersStartArea($player)->getFieldList();
            foreach($startFields as $field) {
                $manStr = $field->hasMan() ? $field->getMan()->getManIdentifier() : ' x ';
                $startArea.= sprintf("|%-3s", $manStr);
            }
            unset($field);

            $targetArea = '';
            $targetFields = $engine->getBoard()->getPlayersTargetArea($player)->getFieldList();
            foreach($targetFields as $field) {
                $manStr = $field->hasMan() ? $field->getMan()->getManIdentifier() : ' x ';
                $targetArea.= sprintf("|%-3s", $manStr);
            }

            $areas.= "StartArea  {$player->getPlayerIdentifier()}: {$startArea} "."\n";
            $areas.= "TargetArea {$player->getPlayerIdentifier()}: {$targetArea} "."\n";
        }
        return $areas;
    }

    protected function _renderCircuit(GameBoardAbstract $board) {
        $boardLine1 = "";
        $boardLine2 = "";
        $boardLine3 = "";
        /** @var  FieldAbstract $field */
        foreach($board->_itearateCircuit() as $index => $field) {

            $manStr = ($field->hasMan()) ? $field->getMan()->getManIdentifier() : '';
            if($field instanceof StartField) {
                $fieldStr = 'S'.strtolower($field->getRelatedPlayerIdentifier());
            } elseif($field instanceof EndField) {
                $fieldStr = 'E'.strtolower($field->getRelatedPlayerIdentifier());
            } else {
                $fieldStr = 'o ';
            }

            $boardLine1.= sprintf("|%-3s", $manStr);
            $boardLine2.= sprintf("|%+3s", $fieldStr);
            $boardLine3.= sprintf("|%+3s", $field->getFieldNr());

            if ($index == ($board->getCircuitLength()-1)) {
                break;
            }
        }

        return "{$boardLine1}\n{$boardLine2}\n{$boardLine3}\n";
    }

    public function announceTheWinner(Player $player) {
        $output = "!!! PLAYER '{$player->getPlayerIdentifier()}'' WIN THE GAME!!!";
        echo $output;
        file_put_contents($this->pathToRenderLog,$output,FILE_APPEND);
    }

}