<?php 

// include in database params (user, p/w, host, db name)
require ('includes/db_info.inc.php');

// Connect to database
$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error() . DB_HOST . DB_USER . DB_PASS . DB_NAME);

?>