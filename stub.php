<?php

include_once('classes/event.class.php');

$event = new Event(NULL,14,'Tour de Marin', 'Fully supported road ride', time(),'Fairfax Plaza',time(),time()+3600);

$event->insert_event($dbc);

?>