<?php
#  passwd_validation.inc.php
#  This include file contains validation code for password fields
#  It checks to see that both password entries were completed and are the same

//  Make sure both passwords were entered
if (isset($_POST['passwd']) && ($_POST['passwd'] != '')) {
	$passwd = mysqli_real_escape_string($dbc, trim($_POST['passwd']));
} else {
	$passwd = '';
	$errors[] = 'Password entry is required';
}
if (isset($_POST['repasswd']) && ($_POST['repasswd'] != '')) {
	$repasswd = mysqli_real_escape_string($dbc, trim($_POST['repasswd']));
} else {
	$repasswd = '';
	$errors[] = 'Password verification entry is required';
}

//  Check if password entries were identical
if (isset($_POST['passwd']) && isset($_POST['repasswd']) && $passwd != $repasswd) {
	$errors[] = 'Passwords do not match!';
}
?>