<?php
#  PHP Programming for the Web - Final project
#  Created April, 2012 by Bob Trigg
#  list_users.php - Displays a paginated list of users

// Check to see if user is logged in - only logged in users may visit this page
session_start();
include('includes/check_access_level.inc.php');

//  User must be admin to use this page
if (!$is_admin) {  

	if (!headers_sent($filename, $linenum)) {
		header("Location: login.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}
}

//  Set number of rows per page.
DEFINE('ROWS_PER_PAGE', 10);

//  Include database functions and utility functions
require_once('includes/db_functions.inc.php');
require_once('includes/functions.inc.php');

//  Display header
$page_title = 'User list';
$header_title = 'User list';
$header_subtitle = 'PHP Programming for the Web, Final Project';
include('includes/header.inc.php');

//  Check for page number in $_GET superglobal
if (isset($_GET['page_num'])) {
	$page_num = $_GET['page_num'];
} else {
	$page_num = 1;
}

//  Include user class definition (needed for static functions)
include_once('classes/user.class.php');

#####  Determine parameters for call to select function
//  Retrieve total number of rows in users table
$total_num_rows = get_num_rows($dbc, 'users');

//  Include logic to assign pagination variables
require_once('includes/set_page_vars.inc.php');

//  Call get_list to parse select query
$row_resource = get_list($dbc, 'users', $start_rec, $num_page_rows, 'username');
?>

<p><a href="create_user.php">Create new user</a></p>

<table id="datatable" width="80%" cellspacing="10" cellpadding="0" border="0">
  <tr>
    <th>User name</th>
	<th>Full name</th>
	<th>Email</th>
	<th>Access</th>
	<th>Edit</th>
	<th>Delete</th>
  </tr>
  
<?php

//  Read each row from users table and display
	while ($user = mysqli_fetch_array($row_resource)) {
	echo "  <tr>\n";
	echo "    <td>" . $user['username'] . "</td>\n";
	echo "    <td>" . $user['first_name'] . " " . $user['last_name'] . "</td>\n";
	echo "    <td>" . $user['email'] . "</td>\n";
	echo "    <td>" . User::text_value($user['access_level']) . "</td>\n";
	echo "    <td><a href=\"edit_user.php?id=" . $user['user_id'] . "\">Edit</a></td>\n";
	echo "    <td><a href=\"delete_user.php?id=" . $user['user_id'] . "\">Delete</a></td>\n";
	echo "  </tr>\n\n";
}

?>
  
  </tr>
</table>

<p><a href="list_events.php">Back to Events</a></p>

<?php

//  Use include file to create the page navigation links

$this_page_name = 'list_users';
include('includes/pagination.inc.php');

include('includes/footer.inc.php');
?>