<?php
#  PHP Programming for the Web - Final project
#  Created April, 2012 by Bob Trigg
#  delete_event.php - Deletes an event specified in URL

//  Retrieve access level setting
session_start();
include('includes/check_access_level.inc.php');

// Only editors (or admin) can delete an event
if (!$is_editor) {

	if (!headers_sent($filename, $linenum)) {
		header("Location: login.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}
}

// Event ID must be provided!
if (isset($_GET['id'])) {
	$event_id = $_GET['id'];
} else {

	if (!headers_sent($filename, $linenum)) {
		header("Location: list_events.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}
}

//  Include table class definition (to allow use of static delete function)
require_once('classes/table.class.php');

if (Table::delete_row($dbc, 'events', 'event_id', $event_id)) {
	$_SESSION['message'] = "Deletion succeeded";
} else {
	$_SESSION['message'] = "Deletion was NOT successful! " . $_SESSION['query'];
}

if (!headers_sent($filename, $linenum)) {
	header ("Location:list_events.php");
	exit();
} else {
	die ( "Headers already sent in $filename on line $linenum<br>\n" .
		  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
		  "<a href=\"login.php\">Click here</a> to re-login\n");
}
?>