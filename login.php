<?php
#  PHP Programming for the Web - Final project
#  Created April, 2012 by Bob Trigg
#  login.php - accepts login id and password; verifies against database 

// Include database and utility functions.
require_once('includes/functions.inc.php');
require_once('includes/db_functions.inc.php');

//  Initialize variables
$errors = array();
$username = ' ';

if (isset($_POST['submitted'])) {

	//  Check the login/password in the database.
	//  check_login returns a Boolean status, plus an array of either fetch data or errors
	list($check, $data) = check_login($dbc, $_POST['username'], $_POST['passwd']);
	
	if ($check) {
		
		// Start sessions and set variables
		session_start();
		$_SESSION['username'] = $data['username'];
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['access_level'] = $data['access_level'];

		// Redirect to loggedin page

		if (!headers_sent($filename, $linenum)) {
			header ("Location: list_events.php");
			exit();
		} else {
			die ( "Headers already sent in $filename on line $linenum<br>\n" .
				  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
				  "<a href=\"login.php\">Click here</a> to re-login\n");
		}
	} else {
		
		//  Login/password not in DB: save returned array of errors
		$errors = $data;
	}
}

//  Display page header, and errors, if any
$page_title = "User login";
$header_title = "User login";
$header_subtitle = "PHP Programming for the Web, Final Project";
include ('includes/header.inc.php');

if (!empty($errors)) {
	foreach ($errors as $error) {
		echo '<p>' . $error . '</p>';
	}
}
?>

<form action="login.php" method="post">

	<p><b>Please login</b></p>
	
	<p><label>User name:</label>
	<input type="text" name="username" value="<?php echo $username; ?>" size="20" maxlength="80" /></p>
	
	<p><label>Password:</label>
	<input type="password" name="passwd" size="20" maxlength="20" /></p>

	<p><span class="label"><input type="submit" name="submit" value="Login" /></span></p>
	
	<input type="hidden" name="submitted" value="TRUE" /></p>

	<p><a href="create_user.php">Create new user</a></p>

</form>

<?php
include ('includes/footer.inc.php');
?>