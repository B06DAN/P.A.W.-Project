<?php

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT',DS.'proiect');
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'inc');

// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

//require_once(LIB_PATH.DS.'function_select.php');


// load core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');

// load database-related classes
require_once(LIB_PATH.DS.'products.php');
//require_once(LIB_PATH.DS.'users.php');
//require_once(LIB_PATH.DS.'event_selectmembers.php');

//require_once(LIB_PATH.DS.'class.upload.php');



if ($session->is_logged_in()) {
$user = Users::find_by_id($session->user_id);
}


?>