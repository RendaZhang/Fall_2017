<?php
	$xml=simplexml_load_file('cars.xml') or 
     die('Error: Cannot create object');
	 
	foreach($xml->children() as $cars) {
		echo $cars->make . ', ';
		echo $cars->model . ', ';
		echo $cars->year . ', ';
		echo $cars->price . '<br>';
	}
?>
