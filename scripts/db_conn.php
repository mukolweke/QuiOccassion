<?php
// deafults
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'qui_event_db');

//Get Heroku ClearDB connection information
$cleardb_url = parse_url('mysql://b4a7b16345653f:6c2395b8@us-cdbr-east-05.cleardb.net/heroku_2ddcdf2d031b934?reconnect=true');
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;

// attempt connection to Mysql DB
// $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$mysqli = new mysqli($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

// checking connection
if($mysqli === false) {
    die('ERROR: Could not connect. ' . $mysqli->connect_error);
}

?>
