<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:23
 */

namespace Pachisi;
use \Pachisi\Field\FieldAbstract;
use \Pachisi\Exception\UnallowedPlayerNumberException;

class Man {

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
     * @param   integer $tokenNumber        The mens number
     * @throws  UnallowedPlayerNumberException
     */
    public function __construct($playerIdentifier, $tokenNumber) {
        $this->_playerIdentifier    = $playerIdentifier;
        $this->_validateRange($tokenNumber);
        $this->_tokenNumber         = $tokenNumber;
    }

    /**
     * Checks if the given $tokenNumber is in range 0-3
     *
     * @param   integer $tokenNumber    The token number to validate
     *
     * @return  bool
     * @throws  UnallowedPlayerNumberException
     */
    protected function _validateRange($tokenNumber) {
        if($tokenNumber >= 0 && $tokenNumber <= 3) {
            return true;
        } else {
            throw new UnallowedPlayerNumberException();
        }
    }

    public function getManIdentifier() {
        return "{$this->_playerIdentifier}#{$this->_tokenNumber}";
    }
}