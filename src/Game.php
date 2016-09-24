<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:04
 */

namespace Pachisi;


class Game {

    const PLAYER_ID_1   = 'blau';
    const PLAYER_ID_2   = 'grün';
    const PLAYER_ID_3   = 'gelb';
    const PLAYER_ID_4   = 'rot';

    /**
     * @var Player[]
     */
    protected $_playerList = array();

    /**
     * @var Dice
     */
    protected $_dice;


    /**
     * @var Man[]
     */
    protected $_manList    = array();

    public function addPlayer(Player $player) {
        $this->_playerList[]   = $player;
    }

    public function addDice(Dice $dice) {
        $this->_dice = $dice;
    }

    public function addMen($men) {
        if( is_array($men) ) {
            foreach($men as $man) {
                $this->addMan($man);
            }
        }
    }

    public function addMan(Man $man) {
        $this->_playerList[$man->getManIdentifier()] = $man;
    }
}