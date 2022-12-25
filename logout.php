<?php

session_start();

$_SESSION = [];

header('Location: guest-page.php');
exit;