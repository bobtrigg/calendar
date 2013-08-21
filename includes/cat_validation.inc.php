<?php
#  cat_validation.inc.php
#  This include file contains validation code for category entry fields
#  It checks to see that all required data was entered and that all entered data is valid.

# Validate entry of category name - must be entered and, if new, must be unique

	if (isset($_POST['cat_name']) && ($_POST['cat_name'] != '')) {
		
		$cat_name = mysqli_real_escape_string($dbc, $_POST['cat_name']);
		$saved_cat_name = mysqli_real_escape_string($dbc, $_POST['saved_cat_name']);
		 
		//  If new category name was entered, make sure it doesn't already exist
		if ($cat_name != $saved_cat_name) {

			//  Use table class static function to check whether category name is unique
			if (name_exists($dbc, 'category', 'cat_name', $_POST['cat_name'])) {
				$errors[] = 'New category name already exists';
			}
		}
	} else {
		$errors[] = 'Category name entry is required';
		$cat_name = '';
	}
?>
