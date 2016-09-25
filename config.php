<?php

// First, set error output ON
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


define('APP_ROOT', __DIR__);
define('LOCAL_CONF', APP_ROOT.DIRECTORY_SEPARATOR.'local_config.php');

$LOG_FILE = APP_ROOT.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'game.log';
$DEBUG_LOG_FILE = APP_ROOT.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'debug.log';
$ERROR_LOG_FILE = APP_ROOT.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'error.log';
$ERROR_VERBOSE = false;

// Overwrite config with values from local_config; in case there is one
if(is_file(LOCAL_CONF) && is_readable(LOCAL_CONF)) {
    require_once LOCAL_CONF;
}

define('LOG_FILE', $LOG_FILE);
define('DEBUG_LOG_FILE', $DEBUG_LOG_FILE);
define('ERROR_LOG_FILE', $ERROR_LOG_FILE);

Pachisi\Logger\LoggerService::truncateLogs();
Pachisi\Logger\LoggerService::logger()->addDebug('local_conf.php used: '.(is_file(LOCAL_CONF) ? 'TRUE' : 'FALSE'));

if($ERROR_VERBOSE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}