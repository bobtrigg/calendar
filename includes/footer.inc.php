<!--  footer.inc.php -->
<!-- Displays copyright and author info -->
	</div>
	<div id="footer">
		<p style="float:left;padding-left:25px;">&copy;  <?php echo date("Y",time());?> <a href="http://www.bobtrigg.com">Bob Trigg</a></p>
		<p class="admin">
		<?php
			if (isset($_SESSION['user_id'])) {    // If user is logged, they can edit their own profile
				echo "<a href=\"edit_user.php\">Profile</a>&nbsp;&nbsp;&nbsp;";
			}
			if (isset($is_admin) && $is_admin) {   //  User must be admin to edit users
				echo "<a href=\"list_users.php\">Users</a></p>\n";
			} else {
				echo "<a href=\"login.php\">Login</a></p>\n";
			}
		?>
	</div>   <!-- END footer -->
</div>   <!-- END wrapper -->
</body>
</html>
<?php if (isset($dbc)) { mysqli_close($dbc); } ?>
<!-- End of footer.html -->