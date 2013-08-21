<?php
#  PHP Programming for the Web
#  Final project
#  Created April, 2012 by Bob Trigg
#  list_categories.php - Displays a paginated list of categories

session_start();

// Check login status and access level. 
include('includes/check_access_level.inc.php');

//   User must have editor privileges to use this script!
if (!$is_admin && !$is_editor) {

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

//  Include database functions file (used to select data for list
require_once('includes/db_functions.inc.php');

//  Display header and session message if set
$page_title = 'Categories';
$header_title = 'Categories';
$header_subtitle = 'PHP Programming for the Web, Final project';
include('includes/header.inc.php');

//  Check for page number in $_GET superglobal
if (isset($_GET['page_num'])) {
	$page_num = $_GET['page_num'];
} else {
	$page_num = 1;
}

#####  Determine parameters for call to select function

//  Retrieve total number of rows in category table
$total_num_rows = get_num_rows($dbc, 'category');

//  Include logic to assign pagination variables
require_once('includes/set_page_vars.inc.php');

//  Call get_list to parse select query
$row_resource = get_list($dbc, 'category', $start_rec, $num_page_rows);

?>

<p><a href="create_cat.php">Create new category</a></p>

<table id="datatable" width="80%" cellspacing="10" cellpadding="0" border="0">
  <tr>
    <th>User name</th>
	<?php if ($is_editor) {  //  Only admins and editors may edit or delete cateories ?>
		<th>Edit</th>
		<th>Delete</th>
	<?php } ?>
  </tr>
  
<?php

//  Read each row from category table and display name and delete link
while ($category = mysqli_fetch_array($row_resource)) {
	echo "  <tr>\n";
	echo "    <td>" . $category['cat_name'] . "</td>\n";
	
	//  If user is editor (or admin) display links for edit and delete functions
	if ($is_editor) { 
		echo "    <td><a href=\"edit_cat.php?id=" . $category['cat_id'] . "\">Edit</a></td>\n";
	
		// Category CANNOT be deleted if it has existing events!
		if (get_num_rows($dbc,'events','WHERE cat_id = ' . $category['cat_id']) == 0) {
			echo "    <td><a href=\"delete_cat.php?id=" . $category['cat_id'] . "\">Delete</a></td>\n";
		}
	}
	
	echo "  </tr>\n\n";
}
?>
  
  </tr>
</table>

<p>Categories with existing events cannot be deleted!</p>

<p><a href="list_events.php">Back to events</a><br></p>

<?php

//  Use include file to create the page navigation links

$this_page_name = 'list_categories';
include('includes/pagination.inc.php');

include('includes/footer.inc.php');
?>