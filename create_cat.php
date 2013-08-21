<?php
#  PHP Programming for the Web
#  Final project
#  Created April, 2012 by Bob Trigg
#  create_cat.php - Creates a new category based on form input

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

// include utility functions
require_once('includes/db_functions.inc.php');
require_once('includes/functions.inc.php');

$errors = array();

if (isset($_POST['submitted'])) {

	include ('includes/cat_validation.inc.php');

	if (empty($errors)) {  // Data entered is valid

		//  Include category class definition and create empty object
		require_once('classes/category.class.php');
		$cat_object = new Category($cat_name);
	
		//  Insert new record
		$result = $cat_object->insert_row($dbc);
		
		if ($result) {
		
			//  Insert succeeded: return to list page
			if (!headers_sent($filename, $linenum)) {
				header("Location: list_categories.php");
				exit();
			} else {
				die ( "Headers already sent in $filename on line $linenum<br>\n" .
					  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
					  "<a href=\"login.php\">Click here</a> to re-login\n");
			}
			
		} else {
			// Insert failed: set error message	
			$errors[] = 'Data could not be added to the database; contact your administrator.';
		}
	}
} else {
	
	// initialize category name variable
	$cat_name = '';
}

$saved_cat_name = '';       //  Indicate categpru name is new and must be tested for uniqueness

//  Display header, and errors if any 
$page_title = 'New Category';
$header_title = 'New Category';
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

<form name="category" method="post" action="create_cat.php">

	<?php include('includes/cat_form.inc.php'); ?>

	<p><a href="list_categories.php">Back to category list</a></p> 

</form>

<?php
include('includes/footer.inc.php');
?>