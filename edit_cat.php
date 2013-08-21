<?php
#  PHP Programming for the Web - Final project
#  Created April, 2012 by Bob Trigg
#  edit_cat.php - Allows change to category name

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

// Category ID must be provided!
if (isset($_GET['id'])) {
	$cat_id = $_GET['id'];
} else {

	if (!headers_sent($filename, $linenum)) {
		header("Location: list_categories.php");
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
	include_once('includes/cat_validation.inc.php');
	
	if (empty($errors)) {  // Data entered is valid
	
		//  include category class definitions and instantiate category object
		require_once('classes/category.class.php');
		$cat_object = new Category($cat_name, $cat_id);

		//  update data in database
		$result = $cat_object->update_row($dbc);
		
		//  Return to list page

		if (!headers_sent($filename, $linenum)) {
			header("Location: list_categories.php");
			exit();
		} else {
			die ( "Headers already sent in $filename on line $linenum<br>\n" .
				  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
				  "<a href=\"login.php\">Click here</a> to re-login\n");
		}
	}
			
} else {
	
	//  Get data for specified primary key
	if (!$return_row = select_by_id($dbc, 'category', 'cat_id', $cat_id)) {
		die("Could not access category data" . mysqli_error($dbc));
	}
	
	//  Assign category data to variables
	$cat_id = $return_row['cat_id'];
	$cat_name = $return_row['cat_name'];
}

$saved_cat_name = $cat_name;       //  Save category name; if it changes, new value must be tested for uniqueness

//  Display header, and errors if any 
$page_title = 'Edit Category';
$header_title = 'Edit Category';
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

<form name="cat" method="post" action="edit_cat.php?id=<?php echo $cat_id; ?>">

<?php require('includes/cat_form.inc.php'); ?>

</form>

<p><a href="list_categories.php">Back to Categories</a></p>

<?php
include('includes/footer.inc.php');
?>