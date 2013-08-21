<?php
#  PHP Programming for the Web - Final project
#  Created April, 2012 by Bob Trigg
#  edit_user.php - allows changes to profile (first and last name, email, and access level); 
#    - includes link to change password

//  Retrieve access level setting
session_start();
include('includes/check_access_level.inc.php');

//  Get user ID: if not in URL, use current user's ID
if (isset($_GET['id'])) {                     //  ID provided in URL
	$user_id = $_GET['id'];
} elseif (isset($_SESSION['user_id'])) {      //  ID for current user in seesion superglobal
	$user_id = $_SESSION['user_id'];
} else {                                      //  No ID provided: return to user list

	if (!headers_sent($filename, $linenum)) {
		header("Location: list_users.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}
}

//   User must be admin, or editing their own profile
if (!$is_admin && $user_id != $_SESSION['user_id']) {

	if (!headers_sent($filename, $linenum)) {
		header("Location: login.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}
}

$errors = array();

//  Include utility and database functions
require_once('includes/functions.inc.php');
require_once('includes/db_functions.inc.php');

//  Need the encrypted password to instantiate the user object
//  For the update, we need to use the existing, encrypted password
//  The password CANNOT be chanaged in this script; see change_passwd.php instead

$curr_user_data = select_by_id ($dbc, 'users', 'user_id', $user_id);
$curr_passwd = $curr_user_data['passwd'];

$new_user = false;

if (isset($_POST['submitted'])) {

	//  include event class definitions and instantiate event object
	require_once('classes/user.class.php');
	$user_object = new User($_POST['username'], $curr_passwd, $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['access_level'], $user_id);
	
	//  Validate user data entries with included file
	include('includes/user_validation.inc.php');

	if (empty($errors)) {  // Data entered is valid
	
		//  update data in database
		$result = $user_object->update_row($dbc);
		
		if ($result) {
		
			//  If user editing own profile, update username session variable
			if ($user_id == $_SESSION['user_id']) { 
				$_SESSION['username'] = $username;
			}
			
			//  Redirect to appropriate page:
			if ($user_id == $_SESSION['user_id']) {      //  User editing own profile: go to events list

				if (!headers_sent($filename, $linenum)) {
					header ("Location: list_events.php");
					exit();
				} else {
					die ( "Headers already sent in $filename on line $linenum<br>\n" .
						  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
						  "<a href=\"login.php\">Click here</a> to re-login\n");
				}
			} elseif ($is_admin) {                       //  Admin user: go to users list page

				if (!headers_sent($filename, $linenum)) {
					header ("Location: list_users.php");
					exit();
				} else {
					die ( "Headers already sent in $filename on line $linenum<br>\n" .
						  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
						  "<a href=\"login.php\">Click here</a> to re-login\n");
				}
			} else {                                     //  Shouldn't have gotten here; go to login page

				if (!headers_sent($filename, $linenum)) {
					header ("Location: login.php");
					exit();
				} else {
					die ( "Headers already sent in $filename on line $linenum<br>\n" .
						  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
						  "<a href=\"login.php\">Click here</a> to re-login\n");
				}
			}
		
		} else {
			$errors[] = 'Data could not be added to the database; contact your administrator.';
		}
	}
} else {

	//  Get user data for provided ID
	$user_data = select_by_id ($dbc, 'users', 'user_id', $user_id);
	$username = $user_data['username'];
	$first_name = $user_data['first_name'];
	$last_name = $user_data['last_name'];
	$email = $user_data['email'];
	$access_level = $user_data['access_level'];
	
	$saved_username = $username;
}

// Program arrives here if form has not yet been submitted, or there are errors:
// display header, and errors if any 
	
$page_title = 'Edit profile';
$header_title = 'Edit Profile';
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

<form name="edit_profile" method="post" action="edit_user.php?id=<?php echo $user_id; ?>">

	<?php include('includes/user_form.inc.php'); ?>
	
	<p><input type="submit" name="submit" value="Submit" /></p>
	<input type="hidden" name="submitted" value="1" />

	<p><a href="change_passwd.php?id=<?php echo $user_id; ?>">Change password</a><br>

		<?php 
			if ($is_admin) {
				echo '<a href="list_users.php">Back to user list</a>';
			} else {
				echo '<a href="list_events.php">Back to events list</a>';
			}
		?>
	</p>

</form>

<?php
include('includes/footer.inc.php');
?>