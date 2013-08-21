	<p>
        <span class="label"><label for="event_date">Date:</label></span>
        <input name="event_date" type="text" id="event_date" size="20" maxlength="20" value="<?php echo $event_date; ?>">
		<br><span class="instruction">Format: mm/dd/yyyy</span>
	</p>
	
	<p>
        <span class="label"><label for="event_name">Event:</label></span>
        <input name="event_name" type="text" id="event_name" size="20" maxlength="40" value="<?php echo $event_name; ?>">
    </p>
	
	<p>
        <span class="label"><label for="cat_id">Category:</label></span>
		<select name="cat_id" id="cat_id" size="1" type="text">

<?php     #### Populate category options by reading through table

		//  Get number of rows in category table
		$total_cat_rows = get_num_rows($dbc, 'category');
		
		//  Begin finding rows
		$row_resource = get_list($dbc, 'category', 1, $total_cat_rows);

		//  Read each row from category table and add to select menu
		while ($category = mysqli_fetch_array($row_resource)) {
		
			//  Make category id the option value
			$option = '  <option value="' . $category['cat_id'] . '"';
			
			//  If this is the category for the current event, make it the selected value 
			if ($category['cat_id'] == $cat_id) {
				$option .= " selected";
			}
			
			//  Finish option line with the category name
			$option .= '>' . $category['cat_name'] . '</option>';
			
			//  Send menu option to HTML
			echo $option;
		}
?>
		</select>
    </p>
	
	<p>
        <span class="label"><label for="description">Description:</label></span>
		<textarea rows="4" cols="60" name="description"><?php echo $description; ?></textarea>
		<br><span class="instruction">Limit: 400 characters</span>
    </p>
	
	<p>
        <span class="label"><label for="location">Location:</label></span>
        <input name="location" type="text" id="location" size="20" maxlength="60" value="<?php echo $location; ?>">
    </p>
	
	<p>
        <span class="label"><label for="address">Address:</label></span>
        <input name="address" type="text" id="address" size="50" maxlength="60" value="<?php echo $address; ?>">
    </p>
	
	<p>
        <span class="label"><label for="city">City:</label></span>
        <input name="city" type="text" id="city" size="20" maxlength="25" value="<?php echo $city; ?>">
    </p>
	
	<p>
        <span class="label"><label for="state">State:</label></span>
        <input name="state" type="text" id="state" size="2" maxlength="2" value="<?php echo $state; ?>">
    </p>
	
	<p>
        <span class="label"><label for="start_time">Start time:</label></span>
		<select name="start_time" id="start_time" size="1" type="text">
		<?php $current_time_value = $start_time; include ('includes/time_options.inc.php'); ?>
        </select>
    </p>
	
	<p>
        <span class="label"><label for="end_time">End time:</label></span>
		<select name="end_time" id="end_time" size="1" type="text">
		<?php $current_time_value = $end_time; include ('includes/time_options.inc.php'); ?>
        </select>
    </p>
	
	<p><input type="submit" name="submit" value="<?php echo $is_editor?"Submit":"Return to listing"; ?>" /></p>
	<input type="hidden" name="submitted" value="1" />
