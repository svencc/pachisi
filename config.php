<?php

// First, set error output ON, so we are able to see what happens via startup of application
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// define application paths
define('APP_ROOT', __DIR__);
define('LOCAL_CONF', APP_ROOT.DIRECTORY_SEPARATOR.'local_config.php');

$LOG_FILE = APP_ROOT.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'game.log';
$DEBUG_LOG_FILE = APP_ROOT.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'debug.log';
$ERROR_LOG_FILE = APP_ROOT.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'error.log';


// Define Error verbosity
$ERROR_VERBOSE = false;


// Configure RandomOrg API
$USE_RANDOMORG_API = false;
$RANDOMORG_API_KEY = '00000000-0000-0000-0000-000000000000';


// Overwrite config with values from local_config; in case there is one
if(is_file(LOCAL_CONF) && is_readable(LOCAL_CONF)) {
    require_once LOCAL_CONF;
}



// DEFINE VALUES
define('LOG_FILE', $LOG_FILE);
define('DEBUG_LOG_FILE', $DEBUG_LOG_FILE);
define('ERROR_LOG_FILE', $ERROR_LOG_FILE);

define('ERROR_VERBOSE', $ERROR_VERBOSE);

define('USE_RANDOMORG_API', $USE_RANDOMORG_API);
define('RANDOMORG_API_KEY', $RANDOMORG_API_KEY);



// Prepare logging
Pachisi\Logger\LoggerService::truncateLogs();
Pachisi\Logger\LoggerService::logger()->addDebug('local_conf.php used: '.(is_file(LOCAL_CONF) ? 'TRUE' : 'FALSE'));



// Control error verbosity
if($ERROR_VERBOSE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}