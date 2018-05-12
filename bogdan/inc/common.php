<?php

error_reporting(E_ALL);
require_once (__DIR__ . '/db.php');
require_once (__DIR__ . '/config.php');
require_once (__DIR__ . '/database_object.php');
require_once (__DIR__ . '/products.php');
require_once (__DIR__ . '/functions.php');
require_once (__DIR__ . '/users.class.php');
require_once (__DIR__ . '/session.php');
require_once (__DIR__ . '/table.class.php');
$db = new MySQLDatabase();
//$database->set_charset('utf8');

//$user=$session->get_user();

