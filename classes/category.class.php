<?php
#  PHP Programming for the Web
#  Final Project
#  Created April, 2012, by Bob Trigg
#  category.class.php - category class definition

require_once('classes/table.class.php');

class Category extends Table {

	protected $pk_id;
	protected $data_array;

######  Constructor function creates a new category
######  function assigns primary key value and an array of other column values, then calls parent (table) constructor
	
	public function __construct($cat_name, $cat_id = NULL) {
	
		$this->pk_id = (int)$cat_id;
		$this->data_array = array('cat_name'=>(string)$cat_name);
		parent::__construct('category', 'cat_id', array('cat_name'));
	}
	
######  Getters and setters

	public function set_cat_name ($cat_name) {
		$this->data_array['cat_name'] = (string) $cat_name;
	}
}	
?>