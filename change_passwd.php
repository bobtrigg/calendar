<?php
#  PHP Programming for the Web - Final Project
#  Created April, 2012 by Bob Trigg
#  change_passwd.php - change password for specified user

//  Retrieve access level setting
if (!headers_sent($filename, $linenum)) {

	session_start();
	include('includes/check_access_level.inc.php');

	//  Get user ID: if not in URL, use current user's ID
	if (isset($_GET['id'])) {                     //  ID provided in URL
		$user_id = $_GET['id'];
	} elseif (isset($_SESSION['user_id'])) {      //  ID for current user in seesion superglobal
		$user_id = $_SESSION['user_id'];
	} else {                                      //  No ID provided: return to user list
		header("Location: list_users.php");
		exit();
	}

	//   User must be admin, or editing their own profile
	if (!$is_admin && $user_id != $_SESSION['user_id']) {
		header("Location: login.php");
		exit();
	}
} else {

	//  Headers have been sent; terminate with an error message and link
	//  A shout out to php.net for the basis of the following code 
	
	die ( "Headers already sent in $filename on line $linenum<br>\n" .
		  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
		  "<a href=\"login.php\">Click here</a> to re-login\n");
}

//  Include database functions
require_once('includes/db_functions.inc.php');
// require_once('includes/functions.inc.php');

//  Get user data; assign $username variable
$user_data = select_by_id ($dbc, 'users', 'user_id', $user_id);
$username = $user_data['username'];

$errors = array();

if (isset($_POST['submitted'])) {

	// Validate entry with includes file
	include('includes/passwd_validation.inc.php');
	
	if (empty($errors)) {    //  Data is OK - update password
		
		//  Include user class definition
		require_once('classes/user.class.php');

		$user_object = new User($user_data['username'], $_POST['passwd'], $user_data['first_name'], $user_data['last_name'], $user_data['email'], $user_data['access_level'], $user_id);

		$result = $user_object->update_passwd($dbc);
		
		if ($result) {
		
			//  Redirect to user list page
			if (!headers_sent($filename, $linenum)) {
				header ("Location: list_users.php");
				exit();
			} else {
				die ( "Headers already sent in $filename on line $linenum<br>\n" .
					  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
					  "<a href=\"login.php\">Click here</a> to re-login\n");
			}
				
		} else {
		
			//  There was an error in writing the data
			$errors[] = 'Password could not be updated.';
		}
	}
}

// Program arrives here if form has not yet been submitted, or there are errors:
// display header, and errors if any 
	
$page_title = 'Change password';
$header_title = 'Change password';
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

<form name="chg_passwd" method="post" action="change_passwd.php?id=<?php echo $user_id; ?>">

	<p>
		<span class="label">Username:</span>
		<?php echo $username; ?>
	</p>
	
	<?php include('includes/passwd_flds.inc.php'); ?>

	<p><input type="submit" name="submit" value="Submit" /></p>
	<input type="hidden" name="submitted" value="1" />
	
	<p>
		<?php if ($is_admin) { echo '<a href="list_users.php">Back to user list</a><br>'; } ?>
		<a href="edit_user.php?id=<?php echo $user_id; ?>">Back to user entry</a>
	</p>

</form>

<?php
include('includes/footer.inc.php');
?>