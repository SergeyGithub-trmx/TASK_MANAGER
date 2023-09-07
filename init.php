<?php

session_start();

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require_once('functions.php');
require_once('db-func.php');
require_once('helpers.php');
require_once('const.php');

$config = require_once('config\db.php');
$mysqli = mysqli_connect(...$config);

if (!$mysqli) {
    http_response_code(500);
    exit;
};