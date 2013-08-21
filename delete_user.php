<?php
#  PHP Programming for the Web - Final project
#  Created April, 2012 by Bob Trigg
#  delete_user.php - Deletes a user specified by id in URL

//  Retrieve access level setting
session_start();
include('includes/check_access_level.inc.php');

// Only admin users can delete a user
if (!$is_admin) {

	if (!headers_sent($filename, $linenum)) {
		header("Location: login.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}
}

// User ID must be provided!
if (isset($_GET['id'])) {
	$user_id = $_GET['id'];
} else {

	if (!headers_sent($filename, $linenum)) {
		header("Location=list_users.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}
}

//  Include table class definition (to allow use of static delete function)
require_once('classes/table.class.php');

//  Go directly to table object method to delete row
//  No need to instantiate user object: we've already got the id we need.
if (Table::delete_row($dbc, 'users', 'user_id', $user_id)) {
	$_SESSION['message'] = "Deletion succeeded";
} else {
	$_SESSION['message'] = "Deletion was NOT successful! " . $_SESSION['query'];
}

if (!headers_sent($filename, $linenum)) {
	header ("Location:list_users.php");
	exit();
} else {
	die ( "Headers already sent in $filename on line $linenum<br>\n" .
		  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
		  "<a href=\"login.php\">Click here</a> to re-login\n");
}
?>