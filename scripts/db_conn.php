<?php

// deafults
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'qui_event_db');

// attempt connection to Mysql DB
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// checking connection
if($mysqli === false) {
    die('ERROR: Could not connect. ' . $mysqli->connect_error);
}
?>
