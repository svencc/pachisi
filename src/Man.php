<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:23
 */

namespace Pachisi;
use Pachisi\Board\GameBoardAbstract;
use \Pachisi\Field\FieldAbstract;
use \Pachisi\Validator\Exception\OutOfRangeException;
use \Pachisi\Validator\Validator;
use \Pachisi\Collection\iCollectibleItem;

class Man implements iCollectibleItem  {

    /**
     * @var FieldAbstract
     */
    protected $_currentPosition;

    /**
     * @var string
     */
    protected $_playerIdentifier;

    /**
     * @var integer
     */
    protected $_tokenNumber;

    /**
     * Man constructor.
     *
     * @param   string  $playerIdentifier   Defines to which player this man belongs
     * @param   integer $tokenNumber        The man´s number
     *
     * @throws  OutOfRangeException
     */
    public function __construct($playerIdentifier, $tokenNumber) {
        $this->_playerIdentifier    = $playerIdentifier;
        Validator::_validateRange(0,3,$tokenNumber);
        $this->_tokenNumber         = $tokenNumber;
    }

    public function getManIdentifier() {
        return "{$this->_playerIdentifier}#{$this->_tokenNumber}";
    }

    public function getPlayerIdentifier() {
        return $this->_playerIdentifier;
    }

    public function getCurrentPosition() {
        return $this->_currentPosition;
    }

    public function setCurrentPosition(FieldAbstract $newPosition) {
        $this->_currentPosition = $newPosition;
    }

    public function removeCurrentPosition() {
        $this->_currentPosition = null;
    }

    public function getUID() {
        return $this->getManIdentifier();
    }
}