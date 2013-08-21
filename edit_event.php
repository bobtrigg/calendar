<?php
#  PHP Programming for the Web - Final project
#  Created April, 2012 by Bob Trigg
#  edit_event.php - Accepts changes to event row and updates row

//  Retrieve access level setting
session_start();
include('includes/check_access_level.inc.php');

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

// include database functions, and general functions
require_once('includes/db_functions.inc.php');
require_once('includes/functions.inc.php');

//  Initialize errors array
$errors = array();

if (isset($_POST['submitted'])) {

	if (!$is_editor) {

		if (!headers_sent($filename, $linenum)) {
			header("Location: list_events.php");
			exit();
		} else {
			die ( "Headers already sent in $filename on line $linenum<br>\n" .
				  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
				  "<a href=\"login.php\">Click here</a> to re-login\n");
		}
	}

	//  Validate form fields; store errors in errors array
	include_once('includes/event_fld_validation.inc.php');
	
	if (empty($errors)) {  // Data entered is valid
	
		//  include event class definitions and instantiate event object
		require_once('classes/event.class.php');
		$event_object = new Event($cat_id, $event_name, $description, db_format_date($event_date), $location, $address, $city, $state, $start_time, $end_time, $event_id);

		//  update data in database
		$result = $event_object->update_row($dbc);
		
		//  Return to list page
		header("Location: list_events.php");
		exit();
	}
	
} else {
	
	//  Get data for specified primary key
	if (!$return_row = select_by_id($dbc, 'events', 'event_id', $event_id)) {
		die("Could not access event data" . mysqli_error($dbc));
	}
	
	//  Assign event data to variables (use display_date() to reformat date)
	$event_name = $return_row['event_name'];
	$cat_id = $return_row['cat_id'];
	$event_date = display_date($return_row['event_date']);
	$description = $return_row['description'];
	$location = $return_row['location'];
	$address = $return_row['address'];
	$city = $return_row['city'];
	$state = $return_row['state'];
	$start_time = $return_row['start_time'];
	$end_time = $return_row['end_time'];
	
}

//  Display header, and errors if any 
$page_title = 'Edit Event';
$header_title = 'Edit Event';
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

<form name="event" method="post" action="edit_event.php?id=<?php echo $event_id; ?>">

<?php require('includes/event_form.inc.php'); ?>

</form>

<p><a href="list_events.php">Back to Events</a></p>

<?php
include('includes/footer.inc.php');
?>