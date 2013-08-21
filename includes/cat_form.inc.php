<!--
#  cat_form.inc.php
#  This include file contains form object tags for category fields
-->

<p>
	<span class="label"><label for="cat_name">Category:</label></span>
	<input name="cat_name" type="text" id="cat_name" size="20" maxlength="20" value="<?php echo $cat_name; ?>">
</p>

<p><input type="submit" name="submit" value="Submit" /></p>
<input type="hidden" name="submitted" value="1" />

<input type="hidden" name="saved_cat_name" value="<?php echo $saved_cat_name; ?>" />

<!--  END cat_form.inc.php -->