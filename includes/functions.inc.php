<?php
// functions.php
// includes functions for Final project

function check_login($dbc, $username = '', $passwd = '') {

#  check_login checks that username and password were entered.
#  It then runs a select query based on provided username
#  Using crypt(), it checks whether the password matches the encrypted one in the user data
#  It returns an array consisting of a Boolean indicating whether username/password 
#    is in the database, and an array of either the selected DB row or the errors found.
	
	//  Include database functions
	$errors = array();
	
	//  Validate entry of username
	if (empty($username)) {
		$errors[] = 'You forgot to enter your username.';
	} else {
		$username = mysqli_real_escape_string($dbc, trim($username));
	}
	
	//  Validate entry of password
	if (empty($passwd)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$passwd = mysqli_real_escape_string($dbc, trim($passwd));
	}
	
	if (empty($errors)) {  // Both fields entered; proceed with select
	
		//  Get the users table row for $username
		$result = name_exists($dbc, 'users', 'username', $username);
			$errors[] = 'username = ' . $result['username'];
			$errors[] = 'passwd = ' . $result['passwd'];
		
		//  Test password using crypt()
		if ($result['passwd'] == crypt($passwd, $result['passwd'])) {
		
			//  data was selected successfully
			return array(TRUE, $result);
			
		} else {
			
			//  Entered password does not match database
			$errors[] = 'The username address and password entered do not match those on file.';
			$errors[] = 'passwd = ' . $result['passwd'];
		}
		
	} // END if (empty($errors))

	// Only valid possibility returns true above
	return array(false, $errors);  
	
} // END function check_login

function construct_where_clause($cat_select, $start_date, $end_date=NULL) {

#  Constructs WHERE clause for selectively displaying events
#  Parameters are an area of category IDs and start and end dates
#  WHERE clause must include all categories selected (unless all categories was selected)
#  It also should include starting and ending dates if the user specified them

	//  initialize clause
	$where_clause = '';

	if (!isset($cat_select[0]) || $cat_select[0] != 0) {  //  Determines whether user selected all categories
	
		$where_clause .= " cat_id IN ( ";
		
		$first_cat = true;   //  Use this var to NOT add a comma before the first ID in the list
		
		//  Loop through the category array, adding each ID to the IN clause
		foreach ($cat_select as $category) {
		
			if ($first_cat) {
				$first_cat = false;
			} else {
				$where_clause .= ", ";
			}
			
			$where_clause .= $category;
		}
		//  Close IN clause
		$where_clause .= ") ";
	}
	
	if ($start_date) {
	
		//  Is there content in the clause? If so, append 'AND'
		if ($where_clause != '') { 
			$where_clause .= " AND ";
		}
		
		//  Event date must be on or after start date
		$where_clause .= "event_date >= '" . db_format_date($start_date) . "' ";
	}
	if ($end_date) {
	
		//  Is there content in the clause? If so, append 'AND'
		if ($where_clause != '') {
			$where_clause .= " AND ";
		}
		
		//  Event date must be on or before end date
		$where_clause .= "event_date <= '" . db_format_date($end_date) . "' ";
	}
	
	//   Once clause is completely constructed, prepend 'WHERE'
	if ($where_clause != '') {
		$where_clause = " WHERE " . $where_clause;
	}
	
	return $where_clause;
}  //  END construct_where_clause

function valid_date($date_str) {

#  Checks entered date for valid format.
#  Date is requested in mm/dd/yyyy format
#  If user enters a 2 digit year, will convert to 4 digit
#  Returns date (with 4 digit year), or false if invalid

	//  Initialize errors array
	$errors = array();
	
	//  Make sure date was entered
	if ($date_str == '') {
		$errors[] = 'Event date entry is required';
	}
	
	list($month,$day,$year) = explode('/', $date_str);
	
	//  Convert string to an array of month, date, year, and use checkdate() to validate
	if (!checkdate($month,$day,$year)) {
		$errors[] = 'Date is not valid (must be mm/dd/yyyy format)';
	}
	
	$iyear = (int)$year;
	
	
	if ($iyear < 100) {
		$year = ($iyear > 50) ? ($iyear + 1900) : ($iyear + 2000);
	}
	
	if (empty($errors)) {  
	
		// entry passes validation tests; return date type 
		return $month . "/" . $day . "/" . $year;
		
	} else {
		
		// Entry is incorrect, return errors array
		return false;
	}
}
function display_date($date) {

#  Converts a date in YYYY-MM-DD format to a friendly format for display
#  Returns reformated date

	#####  Get date components
	list($year,$month,$day) = explode('-',$date);
	
	#####  Reformat using components
	
	//  Cast components to ints to suppress leading zeroes
	$month = (int) $month;
	$day = (int) $day;
	
	return $month . "/" . $day . "/" . $year;
}

function db_format_date($date) {

#  Converts a date in m/d/y format to a YYYY-MM-DD format for insertion into database
#  Returns reformated date

	#####  Get date components
	list($month,$day,$year) = explode('/',$date);

	#####  Reformat using components
	
	return $year . "-" . $month . "-" . $day;
}

function display_time($time) {

#  Converts a time in HH:MM:SS format to a friendly format for display
#  Returns reformated time

	#####  Get time components
	list($hour,$minute,$second) = explode(':',$time);
	
	#####  Reformat using components
	
	//  Set AM or PM based on value of $hour
	$am_pm = ($hour >= 12) ? 'PM' : 'AM';   // AM or PM, dependent on hour value
	
	//  Set correct hour, in 12 hour format
	$hour = $hour > 12 ? $hour -12 : $hour;
	if ($hour == 0) {
		$hour = 12;
	}
	//  Strip leading zero
	if ($hour < 10 && strlen($hour) > 1) {
		$hour = substr($hour, 1,1);
	}
	
	$display_time = $hour . ":" . $minute . " " . $am_pm;
	
	return $display_time;
}
function send_email_confirm($username, $fname, $lname, $email) {

#  Sends an email confirmation to new user at the specified email

	// Assemble message
	$body = "This email confirms your registration in the user database at bobtrigg.com.";
	$body .= "\n\n\tUsername: $username\n\tPassword: your password\n\tFirst name: $fname\n\tLast name: $lname\n\tEmail: $email.";

	//  wordwrap body to prevent truncation
	$body = wordwrap($body, 70);
	
	//  Send mail
	mail($email, 'Confirmation of your registration', $body, "From: <Bob Trigg> bobtrigg94930@gmail.com");				
}
?>