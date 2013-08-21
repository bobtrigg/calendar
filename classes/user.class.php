<?php
#  PHP Programming for the Web
#  Final Project
#  Created April, 2012, by Bob Trigg
#  user.class.php - user class definition

require_once('classes/table.class.php');

class User extends Table {

	protected $pk_id;
	protected $data_array;

######  Constructor function creates a new category
######  This constructor DOES NOT create a DB row; that needs to be done as an additional step
	
	public function __construct($username, $passwd, $first_name, $last_name, $email, $access_level=3, $user_id = NULL) {
	
		$this->pk_id = (int)$user_id;
		
		$this->username = (string)$username;
		$this->passwd = (string)$passwd;
		$this->first_name = (string)$first_name;
		$this->last_name = (string)$last_name;
		$this->email = (string)$email;
		$this->access_level = (int)$access_level;
		
		$this->data_array = array('username' => (string)$username, 
								  'passwd' => (string)$passwd,
								  'first_name' => (string)$first_name,
								  'last_name' => (string)$last_name,
								  'email' => (string)$email,
								  'access_level' => (int)$access_level );
								  
		parent::__construct('users', 'user_id', 
		                     array('username', 'passwd','first_name',
							       'last_name','email','access_level'));
	}
	
######  Database functions

	public function update_passwd($dbc) {
	
	#  Perform an update based on parameter of user_id and new password.
	#  Return Boolean indicating success or failure.

		$query_string = "UPDATE users " .
						" SET passwd = '" . crypt($this->passwd) . "' " .
						" WHERE user_id = '" . $this->pk_id . "' ";
						
		return mysqli_query($dbc, $query_string);
	}

#####  Miscellaneous user-related functions

	public static function text_value($access_level) {
	
	#  Returns the text description of a numeric access level parameter

		switch ($access_level) {
			case 1:
				return "Admin";
				break;
			case 2:
				return "Editor";
				break;
			case 3:
				return "Viewer";
				break;
			default:
				return "Not set";
		}
	}
}
?>