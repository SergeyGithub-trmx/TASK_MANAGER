<?php

session_start();

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require_once('functions.php');
require_once('db-func.php');
require_once('helpers.php');
require_once('const.php');
require_once('classes\Database.php');
require_once('classes\QueryBuilder.php');

$db = Database::getInstance();
