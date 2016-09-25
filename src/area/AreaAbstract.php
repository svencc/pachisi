<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:23
 */

namespace Pachisi\Area;
use Pachisi\Field\FieldAbstract;
use Pachisi\Player;


abstract class AreaAbstract {

    /**
     * @var string  The playerIdentifier this area belongs to
     */
    protected $_playerIdentifier;

    /** @var FieldAbstract[]  */
    protected $_fieldList = array();

    /**
     * @return \Pachisi\Field\FieldAbstract[]
     */
    public function getFieldList() {
        return $this->_fieldList;
    }

    public function __construct(Player $player) {
        $this->_playerIdentifier = $player->getUID();
        $this->_fieldList = $this->_initFields($player);
    }

    abstract protected function _initFields(Player $player);
}