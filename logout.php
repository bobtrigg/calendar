<?php
#  PHP Programming for the Web
#  Assignment 4
#  Created April, 2012
#  Created by Bob Trigg
#  logout.php - logs user out: destroys session variables and redirects to login page

session_start();

$_SESSION = array();
session_destroy();
setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);

header("Location: login.php");
exit();

?>