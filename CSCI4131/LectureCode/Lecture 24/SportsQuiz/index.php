<?php
ini_set('display_errors','1');
error_reporting(E_ALL);

include 'connectDB.php';


// Handling the next and start button - post not set, this means we are in the start state
if(isset($_POST['action'])){
	$action = $_POST['action']; // get the action - we are in the Quiz  

} else{
	$action = 'start';
}


if(isset($_POST['question'])){ // if we have no question response, we have been called from the start page
	$question = $_POST['question'];
        $answer = $_POST['answer'];
}

if (!isset($db))
{
	$db = new connectDB(); // create an instance of the database - Connection to database
}


// Handling the Users answers as input parameters to insertValues
// insertValues stores the data in the database by constructing a SQL UPDATE Query
if (isset($question))
{

	switch($question){

     case '1':
         $db->insertValues('1', $answer); 
	 break;

     case '2':
         $db->insertValues('2', $answer); 
         break;

      case '3':
         $db->insertValues('3', $answer); 
         break;
	}
}



switch($action){
	case 'start':
		include('start.php');break;

	case 'Quiz':
		$val = $_POST['next'];
		switch($val){
			case '1':
				include('Question1.php');
				break;
			case '2':
				include('Question2.php');
				break;
			case '3':
				include('Question3.php');
                                break;

            case '4':
                 $question1 = $db->results('1'); // gets the results of the quiz from the DB
                 $question2 = $db->results('2'); // by selecting the data from each row of the db
                 $question3 = $db->results('3');

                 require_once('Template.php'); // Template.php is the answer template
				break;
		}
		break;
}

?>

