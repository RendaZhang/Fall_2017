<?php
libxml_use_internal_errors(true);

$myXMLData =
"<?xml version='1.0' encoding='UTF-8'?>
 <document>
 <name>Jim Smith</nam>
 <address>jsmith1@lucent.com</addr>
 </document>";
 
$myxml = simplexml_load_string($myXMLData);


    if ($myxml === false) {
		echo 'Failed loading XML: ';
        foreach(libxml_get_errors() as $error) {
			echo '<br>' . $error->message;
		}
	}
	else {
		var_dump($myxml);
	}
	
?>
