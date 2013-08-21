<?php
#  user_validation.inc.php
#  This include file contains validation code for user entry fields
#  It checks to see that all required data was entered and that all entered data is valid.

# Validate entry of username - must be entered and be unique
if (isset($_POST['username']) && ($_POST['username'] != '')) {
	
	$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
	$saved_username = mysqli_real_escape_string($dbc, trim($_POST['saved_username']));
	
	//  If new username was entered, make sure it doesn't already exist
	if ($username != $saved_username) {

		//  Use table class static function to check whether username is unique
		if ($return_data = Table::select_by_unique_key($dbc, 'users', 'username', $username)) {
			$errors[] = 'New username already exists';
		}
	}
} else {
	$errors[] = 'First name entry is required';
	$username = '';
}

# Validate entry of first name
if (isset($_POST['first_name']) && ($_POST['first_name'] != '')) {
	$first_name = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
} else {
	$errors[] = 'First name entry is required';
	$first_name = '';
}

# Validate entry of last name
if (isset($_POST['last_name']) && ($_POST['last_name'] != '')) {
	$last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
} else {
	$errors[] = 'Last name entry is required';
	$last_name = '';
}

# Validate entry of email
if (isset($_POST['email']) && ($_POST['email'] != '')) {
	$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
} else {
	$errors[] = 'Email entry is required';
	$email = '';
}
#Validate email format
#  RE pattern shamelessly plagiarized from Ullman
if (!preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $email)) {
	$errors[] = 'Email entry is not properly formatted.';
}

#  Validate access level - must be 1, 2, or 3
#  There should never be an invalid entry, though, since input is a pull-down

if (isset($_POST['access_level']) && ($_POST['access_level'] != '')) {
	
	if ($_POST['access_level'] == '1' || $_POST['access_level'] == '2' || $_POST['access_level'] == '3') {
		$access_level = mysqli_real_escape_string($dbc, trim($_POST['access_level']));
	} else {
		$errors[] = "Access level not valid";
	}
	
} else {
	$errors[] = 'Access level entry is required';
	$email = '';
}
?>