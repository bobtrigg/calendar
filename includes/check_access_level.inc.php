<?php
//  Default: no access to admin or editor areas
$is_admin = false;
$is_editor = false;

if (isset($_SESSION['username'])) {             // User is logged in: check access level

	if (isset($_SESSION['access_level'])) {  
	
		if ($_SESSION['access_level'] == '1') {        //  User is an admin w/ universal privileges
			$is_admin = true;
			$is_editor = true;
		} elseif ($_SESSION['access_level'] == '2') {  // User can change events, but not users
			$is_admin = false;
			$is_editor = true;
		}
	}
}
?>