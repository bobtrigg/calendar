<?php
#  event_fld_validation.inc.php - validation code for event form fields

	// Validate event name
	if (isset($_POST['event_name']) && ($_POST['event_name'] != '')) {
		$event_name = mysqli_real_escape_string($dbc, trim($_POST['event_name']));
		
		if (strlen($event_name) > 40) {
			$errors[] = "Event name cannot be more than 40 characters";
		}
		
	} else {
		$errors[] = 'Event name entry is required';
		$event_name = '';
	}
	
	//  Validate category
	if (isset($_POST['cat_id']) && ($_POST['cat_id'] != '')) {
		$cat_id = mysqli_real_escape_string($dbc, trim($_POST['cat_id']));
	} else {
		$errors[] = 'Event name entry is required';
		$cat_id = '';
	}
	
	// Validate date
	if (isset($_POST['event_date']) && ($_POST['event_date'] != '')) {
		
		//  Call validation function for date
		if ($validated_date = valid_date($_POST['event_date'])) {
			$event_date = mysqli_real_escape_string($dbc, trim($validated_date));
		} else {
			$errors[] = "Date is invalid; must be mm/dd/yyyy format";
			$event_date = '';
		}
		
	} else {
		$errors[] = 'Event date entry is required';
		$event_date = '';
	}
	
	// Validate location
	if (isset($_POST['location']) && ($_POST['location'] != '')) {
		$location = mysqli_real_escape_string($dbc, trim($_POST['location']));
		
		if (strlen($location) > 100) {
			$errors[] = "Location cannot be more than 60 characters";
		}
		
	} else {
		$errors[] = 'Event name entry is required';
		$location = '';
	}

	//  Set non-required values, escaping metacharacters: description...
	if (isset($_POST['description']) && (!is_null($_POST['description'])) && ($_POST['description'] != '')) {
	
		$description = mysqli_real_escape_string($dbc, trim($_POST['description']));
		
		if (strlen($description) > 400) {
			$errors[] = "Description cannot be more than 400 characters";
		}
		
	} else {
		$description = "";
	}

	//  ...address...
	if (isset($_POST['address']) && (!is_null($_POST['address'])) && ($_POST['address'] != '')) {
	
		$address = mysqli_real_escape_string($dbc, trim($_POST['address']));
		
		if (strlen($address) > 60) {
			$errors[] = "Address cannot be more than 60 characters";
		}
		
	} else {
		$address = "";
	}

	//  ...city...
	if (isset($_POST['city']) && (!is_null($_POST['city'])) && ($_POST['city'] != '')) {
	
		$city = mysqli_real_escape_string($dbc, trim($_POST['city']));
		
		if (strlen($city) > 25) {
			$errors[] = "City cannot be more than 25 characters";
		}
		
	} else {
		$city = "";
	}

	//  ...state...
	if (isset($_POST['state']) && (!is_null($_POST['state'])) && ($_POST['state'] != '')) {
	
		$state = mysqli_real_escape_string($dbc, trim($_POST['state']));
		
		if (strlen($state) != 2) {
			$errors[] = "State must be exactly 2 characters";
		}
		
	} else {
		$state = "";
	}

	//  ...start time...
	if (isset($_POST['start_time']) && (!is_null($_POST['start_time'])) && ($_POST['start_time'] != '')) {
		$start_time = mysqli_real_escape_string($dbc, trim($_POST['start_time']));
	} else {
		$start_time = "''";
	}

	//   ... and end time.
	if (isset($_POST['end_time']) && (!is_null($_POST['end_time'])) && ($_POST['end_time'] != '')) {
		$end_time = mysqli_real_escape_string($dbc, trim($_POST['end_time']));
	} else {
		$end_time = "''";
	}
?>