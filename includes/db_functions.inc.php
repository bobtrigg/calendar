<?php
// db_functions.inc.php
// include file for database functions

require_once('includes/db_connect.inc.php');

function return_resource($dbc, $query_string) {

#  Performs a select statement based on $query_string parameter
#  Fetch first record and return if retrieved.
#  Return false if failure.

	$user_resource = mysqli_query($dbc, $query_string);
	
	if ($user_resource) {
		return mysqli_fetch_array($user_resource);
	} else {
		return false;
	}
}  //  END function return_resource

function get_num_rows($dbc, $table_name, $where_clause=NULL) {

	#  Creates a query to select the number of rows in the specified table
	#  Assigns query string using table name parameter
	#  Calls return_resource() to execute query, which returns array containing row count.
	#  Returns first element of array from query, which is the row count

		$query_string = "SELECT count(*) " .
						" FROM $table_name ";
						
		if (!is_null($where_clause)) {
			$query_string .= $where_clause;
		}

		$return_array = return_resource($dbc, $query_string);
		
		return $return_array[0];

	}  //  END get_num_rows

function get_list($dbc, $table_name, $start_rec = 1, $num_rows = ROWS_PER_PAGE, $sort_field = NULL, $join_clause = NULL, $where_clause=NULL) {
	
	#  Creates a query to select a set of rows from specified table for display
	#  Uses parameters $start_rec and $num_rows to paginate data, if provided
	#  Uses sort field parameter to sort rows, if provided.
	#  Returns resource from query, which will be used in a foreach in calling script

		$query_string = "SELECT * FROM $table_name ";
		
		//  Add optional JOIN clause
		if (!is_null($join_clause)) {
			$query_string .= " " . $join_clause . " ";
		}

		//  Add optional WHERE clause
		if (!is_null($where_clause)) {
			$query_string .= " " . $where_clause . " ";
		}

		//  Add ORDER BY clause if sort_field is provided
		if (!is_null($sort_field)) {
			$query_string .= " ORDER BY $sort_field ";
		}

		$query_string .= " LIMIT $start_rec, $num_rows ";
			
		return mysqli_query($dbc, $query_string);
	}
	
function select_by_id ($dbc, $table_name, $id_col_name, $id_value) {
		
#  Selects one table row, based on primary key
#  Returns Boolean false if row does not exist
#  Returns value of row if row does exist, which will interpret as true

	$query_string = "SELECT * " .
					" FROM $table_name " .
					" WHERE $id_col_name = '" . $id_value . "' " .
					" LIMIT 1 ";
					
	//  $_SESSION['message'] = $query_string;
	
	return return_resource($dbc, $query_string);

}  //  END select_by_pk
	
function name_exists($dbc, $table_name, $fld_name, $value) {
	
#  Selects one table row, based on table name, field name, and value
#  Returns Boolean false if row does not exist
#  Returns value of row if row does exist, which will interpret as true
#  Used to validate entry of unique fields (cat_name, event_name, username)

	$query_string = "SELECT * " .
					" FROM $table_name " .
					" WHERE $fld_name = '" . $value . "' " .
					" LIMIT 1 ";
					
	 // $_SESSION['message'] = $query_string;
					
	return return_resource($dbc, $query_string);

}  //  END function name_exists
function select_on_user_passwd($dbc, $username, $passwd) {

#  Creates a query to select a  row from users based on username and password
#  Calls return_resource() to execute query and return row.
#  Returns result from return_resource(), which will be a resource, or Boolean false

	$query_string = "SELECT * " .
				 " FROM users " .
				 " WHERE username = '$username' AND passwd = SHA1('$passwd')";
				 
	return return_resource($dbc, $query_string);
		
} //  END function select_on_user_passwd
?>