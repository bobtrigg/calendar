<?php
#  PHP Programming for the Web - Final project
#  Created April, 2012 by Bob Trigg
#  delete_cat.php - Deletes a category specified in URL

//  Retrieve access level setting
session_start();
include('includes/check_access_level.inc.php');

// Only editor can delete a category
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

// Category ID must be provided!
if (isset($_GET['id'])) {
	$cat_id = $_GET['id'];
} else {

	if (!headers_sent($filename, $linenum)) {
		header("Location=list_categories.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}
}

//  Include database function definitions
require_once('includes/db_functions.inc.php');

if (get_num_rows($dbc,'events','WHERE cat_id = ' . $cat_id) != 0)  {
	die("Cannot delete category which has existing events!");
}

//  Include table class definition (to allow use of static delete function)
require_once('classes/table.class.php');

//  Delete row using category object
if (Table::delete_row($dbc, 'category', 'cat_id', $cat_id)) {
	$_SESSION['message'] = "Deletion succeeded";
} else {
	$_SESSION['message'] = "Deletion was NOT successful! " . $_SESSION['query'];
}

if (!headers_sent($filename, $linenum)) {
	header ("Location:list_categories.php");
	exit();
} else {
	die ( "Headers already sent in $filename on line $linenum<br>\n" .
		  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
		  "<a href=\"login.php\">Click here</a> to re-login\n");
}
?>