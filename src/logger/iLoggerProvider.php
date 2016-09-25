<?php
/**
 * Created by PhpStorm.
 * User: carri_000
 * Date: 25.09.2016
 * Time: 07:44
 */

namespace Pachisi\Logger;


interface iLoggerProvider {

    public static function registerNewServiceConsumer(iLoggerConsumer $consumer);

}