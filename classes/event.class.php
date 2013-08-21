<?php
#  PHP Programming for the Web
#  Final Project
#  Created April, 2012, by Bob Trigg
#  event.class.php - event class definition

require_once('classes/table.class.php');

class Event extends Table {

	protected $pk_id;
	protected $data_array;

######  Constructor function creates a new event
######  function assigns primary key value and an array of other column values, then calls parent (table) constructor
	
	public function __construct($cat_id, 
								$event_name, 
								$description=NULL, 
								$event_date=NULL, 
								$location=NULL, 
								$address=NULL, 
								$city=NULL, 
								$state=NULL, 
								$start_time=NULL, 
								$end_time=NULL,
								$event_id=NULL ) 
	{
		$this->pk_id = (int)$event_id;
		
		$this->data_array = array('cat_id' => (int)$cat_id, 
								  'event_name' => (string)$event_name,
								  'description' => (string)$description,
								  'event_date' => $event_date,
								  'location' => (string)$location,
								  'address' => (string)$address,
								  'city' => (string)$city,
								  'state' => (string)$state,
								  'start_time' => $start_time,
								  'start_time' => $start_time,
								  'start_time' => $start_time,
								  'start_time' => $start_time,
								  'end_time' => $end_time );
								  
		parent::__construct('events', 'event_id', 
		                     array('cat_id', 'event_name','description','event_date','location',
							       'address','city','state','start_time','end_time'));
	}	
}
?>