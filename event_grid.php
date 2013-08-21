<?php
#  PHP Programming for the Web - Final project
#  Created April, 2012 by Bob Trigg
#  event_grid.php - Displays events in a calendar grid

//  ini_set('display_errors', 1);
//  Get user's privilege level

session_start();
include('includes/check_access_level.inc.php');

//  Set time zone for Bob's house...NOT in L.A.
date_default_timezone_set('America/Los_Angeles');

//  Include database functions and utility functions
require_once('includes/db_functions.inc.php');
require_once('includes/functions.inc.php');

//  Create object for start date
$start_date = new DateTime();
//  Set date object: session start date or current date if not set
if (isset($_GET['date']) && !is_null($_GET['date']) && $_GET['date'] != '') {
echo $_GET['date'] . '<br>';
	//  Create date object using string components
	list($month,$day,$year) = explode('/',$_GET['date']);
	$start_date->setDate($year, $month, $day);
} else {

    //  If not present, set date object to current date (list_events.php should not allow this)
	$start_date->setTimestamp(date('U'));
	
}
echo 'start date understood<br>';
//echo $start_date . '<br>';

//  Get individual date components array and set component variables
$start_date_array = getdate($start_date->getTimestamp());
echo 'start_date_array initialized<br>';

$month = $start_date_array['mon'];
$month_name = $start_date_array['month'];
$day = $start_date_array['mday'];
$year = $start_date_array['year'];

//  Set previous month dates for navigation
$prev_month = $month - 1;
if ($prev_month == 0) {
	$prev_month = 12; $prev_year = $year - 1;
} else {
	$prev_year = $year;
}
if ($day > 28) {
	$prev_day = 28;
} else {
	$prev_day = $day;
}

//  Set next month dates for navigation
$next_month = $month + 1;
if ($next_month == 13) {
	$next_month = 1; $next_year = $year + 1;
} else {
	$next_year = $year;
}
if ($day > 28) {
	$next_day = 28;
} else {
	$next_day = $day;
}

####  Following several lines set $cell_date to be the Sunday before the first day of the selected month.

//  Set up date object and obtain array of components
$cell_date = $start_date;  //  New date object
$cell_date_array = getdate($cell_date->getTimestamp());

// Subtract day of month minus 1 to get 1st day of month (e.g. 4/12/2012 - 11 = 4/1/2012)
$offset = $cell_date_array['mday'] - 1;
$cell_date->sub(new DateInterval('P' . $offset . 'D'));

// Get new date component array
$cell_date_array = getdate($cell_date->getTimestamp());

//  Subtract day of week to get previous Sunday (since Sunday is 0)
$cell_date->sub(new DateInterval('P' . $cell_date_array['wday'] . 'D'));

####  That's done...

//  Call get_list to parse select query
$total_num_rows = get_num_rows($dbc, 'events');
$where_clause = construct_where_clause($_SESSION['cat_select'], $start_date->format('m/d/Y'), NULL);
$row_resource = get_list($dbc, 'events', 0, $total_num_rows, 'event_date ASC, start_time ASC', NULL, $where_clause);

//  Get first event
if ($event = mysqli_fetch_array($row_resource)) {

	//  Parse event date to obtain components
	list($event_year,$event_month,$event_day) = explode('-',$event['event_date']);
}

//  Display header and session message if set
$page_title = 'Events calendar';
$header_title = 'Events calendar';
$header_subtitle = 'PHP Programming for the Web, Final project';
include('includes/header.inc.php');

?>

<?php 

	//  Current month and navigation links
	echo '<h3>';
	echo '<a href="event_grid.php?date=' . $prev_month . '/' . $prev_day . '/' . $prev_year . '">&lt;Prev</a>&nbsp;&nbsp;';
	echo $month_name . ', ' . $year . '&nbsp;&nbsp;';
	echo '<a href="event_grid.php?date=' . $next_month . '/' . $next_day . '/' . $next_year . '">Next&gt;</a>';
	echo '<span style="padding-left:20px;"><a href="list_events.php">Back to events listing</a></span>';
	echo '</h3>';
?>

<table id="cal_table" width="100%" cellspacing="0" cellpadding="0">

  <?php
  
	//  Just in case, provide mechanism to exit loop after 10 iterations
	$preventinfloop = 0;
	
	while ($cell_date_array['mon'] == $month) {      //  loop through current month's dates

		echo "<tr>\n";

		for ($day_of_week=0;$day_of_week < 7; $day_of_week++) {    //  Loop through one week of dates
		
			$item_count = 0;
			
			echo '<td class="cell" valign="top">';
			
			echo $cell_date->format('j');     //  Numeric day of month 
			
			//  Loop through all events for current day and display them
			while ($event && $event_day == $cell_date->format('j') && ((int)$event_month) == ((int)$cell_date->format('n'))) {
			
				//  Display one event info
				echo '<br>&gt; ' . display_time($event['start_time']) . ': <a href="edit_event.php?id=' .$event['event_id'] . '">' . $event['event_name'] . '</a>';
				
				//  Get the data for the next event
				if ($event = mysqli_fetch_array($row_resource)) {
					list($event_year,$event_month,$event_day) = explode('-',$event['event_date']);
				}
			}
			
			//  Increment table cell date
			$cell_date->add(new DateInterval('P1D'));
					
			echo '</td>' . "\n";
		}
		echo "</tr>\n";
		
		//  Reset table cell data in case we've entered a new month (tested at beginning of loop)
		$cell_date_array = getdate($cell_date->getTimestamp());
		
		//  Just in case...
		if ($preventinfloop++ > 10) break;
	}  //  END while loop thru current month
  ?>



  </tr>
</table>

<?php

include('includes/footer.inc.php');
?>