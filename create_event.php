<?php
#  PHP Programming for the Web - Final Project
#  Created April, 2012 by Bob Trigg
#  create_event.php - Creates a new event based on form input

//  Retrieve access level setting
session_start();
include('includes/check_access_level.inc.php');

//  User must be editor (or admin) to use this script
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

// include database functions, and general functions
require_once('includes/db_functions.inc.php');
require_once('includes/functions.inc.php');

//  Initialize errors array
$errors = array();

if (isset($_POST['submitted'])) {

	//  Validate form fields; store errors in errors array
	include_once('includes/event_fld_validation.inc.php');
	
	if (empty($errors)) {  // Data entered is valid
	
		//  Create a new object for new event; include necessary code files
		require_once('classes/event.class.php');
		$event_object = new Event($cat_id, $event_name, $description, db_format_date($event_date), $location, $address, $city, $state, $start_time, $end_time);
		
		//  Insert new record
		$result = $event_object->insert_row($dbc);
		
		if ($result) {
		
			//  New row inserted - Return to list page
				if (!headers_sent($filename, $linenum)) {
					header("Location: list_events.php");
					exit();
				} else {
					die ( "Headers already sent in $filename on line $linenum<br>\n" .
						  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
						  "<a href=\"login.php\">Click here</a> to re-login\n");
				}
						
		} else {
			
			// Insert failed; add error message
			$errors[] = "Insert failed.";
		}
	}
} else {
	
	// initialize event name variable
	$event_name = $cat_id = $event_date = $description = $location = $address = $city = $state = $start_time = $end_time = '';
}

//  Display header, and errors if any 
$page_title = 'New Event';
$header_title = 'New Event';
$header_subtitle = 'PHP Programming for the Web, Final project';
include('includes/header.inc.php');

if (!empty($errors)) {

	echo "<p>";
	
	foreach ($errors as $msg) {
		echo "$msg<br>\n";
	}
	echo "</p>\n";
}
?>

<form name="event" method="post" action="create_event.php">

<?php require('includes/event_form.inc.php'); ?>

<p><a href="list_events.php">Back to Events</a></p>

</form>

<?php
include('includes/footer.inc.php');
?>