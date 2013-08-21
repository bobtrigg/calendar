<?php
#  PHP Programming for the Web - Final project
#  Created April, 2012 by Bob Trigg
#  list_events.php - Displays a paginated list of events, with links to edit and delete each item

// Check login status and access level. 
session_start();

//  Check user's privilege level
include('includes/check_access_level.inc.php');

//  Set number of rows per page.
DEFINE('ROWS_PER_PAGE', 10);

//  Include database functions and utility functions
require_once('includes/db_functions.inc.php');
require_once('includes/functions.inc.php');

$errors = array();
$where_clause = '';
	
if (isset($_POST['submitted'])) {

	//  Validate date entries

	if (isset($_POST['start_date']) && !is_null($_POST['start_date']) && $_POST['start_date'] != '') {
		if ($validated_date = valid_date($_POST['start_date'])) {
			$start_date = $validated_date;
		} else {
			$errors[] = "Start date is not valid";
		}
	} else {
		$errors[] = 'You <i>must</i> enter a start date!';
	}

	if (isset($_POST['end_date']) && !is_null($_POST['end_date']) && $_POST['end_date'] != '') {
		if ($validated_date = valid_date($_POST['end_date'])) {
			$end_date = $validated_date;
		} else {
			$errors[] = "End date is not valid";
		}
	} else {
		$end_date = '';
	}

	if (empty($errors)) {
	
		if (isset($_POST['format']) && $_POST['format'] == 'grid') {
			
			//  User requests grid format
		
			//  Pass selected categories and start date to calendar grid script
			$_SESSION['cat_select'] = $_POST['cat_select'];
			$_SESSION['start_date'] = $start_date;
		
			//  Go to calendar grid script
			if (!headers_sent($filename, $linenum)) {
				header("Location: event_grid.php?date=$start_date");
				exit();
			} else {
				die ( "Headers already sent in $filename on line $linenum<br>\n" .
					  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
					  "<a href=\"login.php\">Click here</a> to re-login\n");
			}
		} else {
	
			//  Call function to construct WHERE clause from input values
			$where_clause = construct_where_clause($_POST['cat_select'], $_POST['start_date'], $_POST['end_date']);
		}
	}
}

//  Display header and session message if set
$page_title = 'Events';
$header_title = 'Events';
$header_subtitle = 'PHP Programming for the Web, Final project';
include('includes/header.inc.php');

if (!empty($errors)) {

	echo "<p>";
	
	foreach ($errors as $msg) {
		echo "$msg<br>\n";
	}
	echo "</p>\n";
}

//  Check for page number in $_GET superglobal
if (isset($_GET['page_num'])) {
	$page_num = $_GET['page_num'];
} else {
	$page_num = 1;
}

#####  Initialize form variables
$start_date = date('m/d/Y');
$end_date = '';

#####  Determine parameters for call to select function

//  Retrieve total number of rows in event table
$total_num_rows = get_num_rows($dbc, 'events');

//  Include logic to assign pagination variables
require_once('includes/set_page_vars.inc.php');

//  Define JOIN clause to obtain category name
$join_clause = "INNER JOIN category USING (cat_id)";

//  Call get_list to parse select query
$row_resource = get_list($dbc, 'events', $start_rec, $num_page_rows, 'event_date ASC, start_time ASC', $join_clause, $where_clause);
?>

<h3>Choose categories and date range you wish to display</h3>

<form name="event_selector" id="event_selector" method="POST" action="list_events.php">

	<p class="formats">
		<input type="radio" name="format" value="list" checked /> Event list format<br />
		<input type="radio" name="format" value="grid" /> Calendar grid format<br />
	</p>
<!--	<p class="clear">&nbsp;</p>  -->
		
	<p class="event_selector">
	
		<span class="label" style="width:100px;"><label for="cat_select">Category:&nbsp;&nbsp;&nbsp;</label></span>
		
		<select multiple size="<?php echo min(6, $num_cats = get_num_rows($dbc,'category')); ?>" name="cat_select[]">
		
			<option value="0" selected>Show all</option>
			
			<?php  // construct the options for the select menu
			
				$cat_list = get_list($dbc, 'category', 0, $num_cats, 'cat_name');
				
				while ($event = mysqli_fetch_array($cat_list)) {
					echo '<option value="' . $event['cat_id'] . '">' . $event['cat_name'] . '</option>\\n';
				}
			?>
		</select>
		<br><span style="font-size:75%;padding-left:40px;">You may choose any number of categories</span>

	</p>
	
	<p class="event_selector"">
		<label for="start_date">Start date:</label>
		<input name="start_date" type="text" id="start_date" size="15" maxlength="15" value="<?php echo $start_date; ?>">
		<br><span class="instruction">Format: mm/dd/yyyy</span>
	<br>
		<label for="end_date">End date:</label>
		<input name="end_date" type="text" id="end_date" size="15" maxlength="15" value="<?php echo $end_date; ?>">
		<br><span class="instruction">Format: mm/dd/yyyy</span>
	</p>
	
	<p class="clear" style="padding:0;">&nbsp;</p>

	<p><input type="submit" name="submit" value="Display events" /></p>
	<input type="hidden" name="submitted" value="true" />

</form>

<h3>Click on any event to <?php echo $is_editor?'edit':'view'; ?> details</h3>
	
<table id="datatable" width="100%" cellspacing="10" cellpadding="0" border="0">
  <tr>
	<th width="30px">Date</th>
    <th>Event</th>
	<th>Category</th>
<!--	<th>Description</th>   -->
	<th>Location</th>
	<th>Start time</th>
	<th>End time</th>
	<th>Delete</th>
<?php
	//  If user has proper authorization, show edit and delete functions
	// if ($is_editor) {
		// echo "<th>Edit</th>\n";
		// echo "<th>Delete</th>\n";
	// } else {
		// echo "<th>View</th>\n";
	// }
?>
  </tr>
 
<?php

//  Read each row from events table and display data, with edit and delete links
while ($event = mysqli_fetch_array($row_resource)) {

	echo "  <tr>\n";
	echo "    <td>" . display_date($event['event_date']) . "</td>\n";
	echo "    <td><a href=\"edit_event.php?id=" . $event['event_id'] . "\">" . $event['event_name'] . "</a></td>\n";
	echo "    <td>" . $event['cat_name'] . "</td>\n";
//	echo "    <td>" . substr($event['description'], 0, 15);
//	echo strlen($event['description'])<15?" ":"...";
//	echo "</td>\n";
	echo "    <td>" . $event['location'] . "</td>\n";
	echo "    <td>" . display_time($event['start_time']) . "</td>\n";
	echo "    <td>" . display_time($event['end_time']) . "</td>\n";

	//  If user has proper authorization, show edit and delete functions
	// if ($is_editor) {
		// echo "    <td><a href=\"edit_event.php?id=" . $event['event_id'] . "\">Edit</a></td>\n";
		echo "    <td><a href=\"delete_event.php?id=" . $event['event_id'] . "\">Delete</a></td>\n";
	// } else {
		// echo "    <td><a href=\"edit_event.php?id=" . $event['event_id'] . "\">View</a></td>\n";
	// }
	
	echo "  </tr>\n\n";
}
?>

  </tr>
</table>

<?php
	//  If user has privileges, allow to create new events and manage categories
	if ($is_editor) {
		echo "<p><a href=\"create_event.php\">Create new event</a><br>\n";
		echo "<a href=\"list_categories.php\">Manage categories</a></p>\n";
	}
?>

<?php

//  Use include file to create the page navigation links

$this_page_name = 'list_events';
include('includes/pagination.inc.php');

include('includes/footer.inc.php');
?>