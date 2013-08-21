<!--
#  user_form.inc.php
#  This include file contains form object tags for profile fields
-->

	<p>
        <span class="label"><label for="username">Username:</label></span>
        <input name="username" type="text" id="username" value="<?php echo $username; ?>" size="15" maxlength="15">
    </p>	
	
	<?php if ($new_user) {  // Password entry should appear only for new user entry ?>
	
		<p>
			<span class="label"><label for="passwd">Password:</label></span>
			<input name="passwd" type="password" id="passwd"  size="20" maxlength="20">
		</p>
		<p>
			<span class="label"><label for="repasswd">Retype:</label></span>
			<input name="repasswd" type="password" id="repasswd" size="20" maxlength="20">
		</p>

	<?php } ?>
	
	<p>
        <span class="label"><label for="first_name">First Name:</label></span>
        <input name="first_name" type="text" id="first_name" size="20" maxlength="20" value="<?php echo $first_name; ?>">
    </p>
	<p>
        <span class="label"><label for="last_name">Last Name:</label></span>
        <input name="last_name" type="text" id="last_name" size="20" maxlength="30" value="<?php echo $last_name; ?>">
    </p>
	<p>
        <span class="label"><label for="email">Email:</label></span>
        <input name="email" type="text" id="email" size="30" maxlength="30" value="<?php echo $email; ?>">
    </p>
	
	<?php if ($is_admin) {  //  Only admin users may change access level ?>
		<p>
			<span class="label"><label for="access_level">Access level:</label></span>
			<select name="access_level" id="access_level" size="1" type="text">
				<option value="1"<?php echo ($access_level=="1")?" selected":""; ?>>Admin</option>
				<option value="2"<?php echo ($access_level=="2")?" selected":""; ?>>Editor</option>
				<option value="3"<?php echo ($access_level=="3")?" selected":""; ?>>Viewer</option>
			</select>
		</p>
	<?php } else { echo "<input type=\"hidden\" name=\"access_level\" value=\"$access_level\" />"; } ?>
	
	<input type="hidden" name="saved_username" value="<?php echo $saved_username; ?>" />
