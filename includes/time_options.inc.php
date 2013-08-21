<?php

#  Sets up 48 option values for select menu for start time and end time
#  Loops through 24 hours, and prints two options (hour and half past) for each hour
#  Requires that $current_time_value be set in the including script

	//   Loop through 24 hour period to construct select list
	for ($hour=0; $hour<24; $hour++) {

	//  Initialize some helpful varialbles
	$value_hour = sprintf("%02d", $hour);     // two-digit zero-filled hours
	
	if ($hour == 0) {
		$display_hour = "12";                 //  12:00 AM or 12:30 AM
	} else {
		$display_hour = sprintf("%02d", ($hour > 12 ? $hour - 12 : $hour));  //  zero-filled 2 digit 12 hour display string 
	}
	
	$am_pm = ($hour >= 12) ? 'PM' : 'AM';   // AM or PM, dependent on hour value
	
	
	//  If this time is the current value, make it appear in the select menu
	$test_time = sprintf("%02d", $hour) . ":00:00";
	$selected = ($test_time == $current_time_value) ? " selected=\"selected\"" : "";

	echo "<option value=\"$value_hour:00:00\"$selected>$display_hour:00 $am_pm</option>\n";
	
	//  If this time is the current value, make it appear in the select menu
	$test_time = sprintf("%02d", $hour) . ":30:00";
	$selected = ($test_time == $current_time_value) ? " selected=\"selected\"" : "";

	echo "<option value=\"$value_hour:30:00\"$selected>$display_hour:30 $am_pm</option>\n";
	
}
?>