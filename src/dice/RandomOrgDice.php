<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 23.09.2016
 * Time: 21:24
 */

namespace Pachisi\Dice;
use Pachisi\Logger\iLoggerConsumer;
use \RandomOrg\Random;

class RandomOrgDice extends DiceAbstract implements iLoggerConsumer  {

    /** @var Random  */
    protected $_randomOrgApi;

    protected $_generatedNumbersCache = array();

    protected $_prefetchNumberSize = 99;

    protected $_loggerServiceName;

    public function setLoggerServiceName($loggerServiceName) {
        $this->_loggerServiceName = $loggerServiceName;
    }

    public function __construct($apiKey) {
        $this->_randomOrgApi = new Random($apiKey);
        $this->fetchNewNumbersFromApi();
    }

    public function rollDice() {
        //if all prefetched random numbers are consumed we have to fetch another bunch!
        if(count($this->_generatedNumbersCache) == 0) {
            $this->fetchNewNumbersFromApi();
        }
        // Take the first number from cache and removes it
        $theNumber = array_shift($this->_generatedNumbersCache);
        return $theNumber;
    }

    public function changePrefetchNumberSize($amount) {
        $this->_prefetchNumberSize = $amount;
    }

    protected function fetchNewNumbersFromApi() {
        if ($this->_loggerServiceName !== NULL) {
            $service = $this->_loggerServiceName;
            $service::logger()->debug("Prefetched another bunch of random numbers {$this->_prefetchNumberSize}");
        }

        $result = $this->_randomOrgApi->generateIntegers($this->_prefetchNumberSize, 1, 6, TRUE);
        $newNumbers = $result['result']['random']['data'];
        $this->_generatedNumbersCache = array_merge($this->_generatedNumbersCache, $newNumbers);
    }
}