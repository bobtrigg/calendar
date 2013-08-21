<?php
#  PHP Programming for the Web - Final Project
#  Created April, 2012 by Bob Trigg
#  create_user.php - Allows entry and validation of new user

//  Check whether user is logged in: only logged in user may access this page!
session_start();
include('includes/check_access_level.inc.php');

//   Update 5/13/2012 - allow visitors to create their own viewer level user id

// include database functions, and general functions
require_once('includes/db_functions.inc.php');
require_once('includes/functions.inc.php');

$errors = array();       //  Initialize errors array

$new_user = true;        //  Used to indicate need to display password entry on form

if (isset($_POST['submitted'])) {

	//  Include user class definitions
	//  Used also for table class static function in validation
	require_once('classes/user.class.php');
		
	//  Validate password entries with included file
	require_once('includes/passwd_validation.inc.php');

	//  Validate user data entries with included file
	require_once('includes/user_validation.inc.php');

	if (empty($errors)) {
	
		//  Create a new object for new user; encrypt password
		$user_object = new User($username, crypt($passwd), $first_name, $last_name, $email, $access_level);
		
		//  Insert new record
		$result = $user_object->insert_row($dbc);
		
		if ($result) {
		
			// Email new user w/ confirmation
			send_email_confirm($username, $first_name, $last_name, $email);
		
			// Redirect to user listing page
			if (!headers_sent($filename, $linenum)) {
				header ("Location: list_users.php");
				exit();
			} else {
				die ( "Headers already sent in $filename on line $linenum<br>\n" .
					  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
					  "<a href=\"login.php\">Click here</a> to re-login\n");
			}
				
		} else {
			// Insert failed	
			$errors[] = 'Data could not be added to the database; contact your administrator.';
		}
	}
	
} else {

	// Form has not been submitted: initialize entry fields
	$username = $first_name = $last_name = $email = '';
	
	$access_level = "3";  // Default settings: lowest privileges
}

// Program arrives here if form has not yet been submitted, or there are errors:
	
$saved_username = '';       //  Used to see if entered user has changed and must be tested for uniqueness

// display header, and errors if any 
$page_title = 'New user entry';
$header_title = 'New user entry';
$header_subtitle = 'PHP Programming for the Web, Final Project';
include('includes/header.inc.php');

if (!empty($errors)) {

	echo "<p>";
	
	foreach ($errors as $msg) {
		echo "$msg<br>\n";
	}
	echo "</p>\n";
}

?>

<form name="regForm" method="post" action="create_user.php">

	<?php include('includes/user_form.inc.php'); ?>
	
	<p><input type="submit" name="submit" value="Submit" /></p>
	<input type="hidden" name="new_user" value="1" />
	<input type="hidden" name="submitted" value="1" />

</form>

<p style="clear:both;"><a href="list_users.php">Back to user list</a></p>


<?php
include('includes/footer.inc.php');
?>