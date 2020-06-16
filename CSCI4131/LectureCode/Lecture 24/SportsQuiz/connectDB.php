<?php
ini_set('display_errors','1');
error_reporting(E_ALL);

class connectDB
{
    private $con;

    // class constructor and it initiates the connection with the database.
    public function __construct( ) {
         $this->con = mysqli_connect('cse-curly.cse.umn.edu','F17CS4131F16Uxxx','xxxxx','F174131F16Uxxx','3306');
		 
		 // Check connection
		if (mysqli_connect_errno())
		{
		echo 'Failed to connect to MySQL:' . mysqli_connect_error();
		exit(1);
		}
    }
     

    // Insert the user answers into the database.
    public function insertValues($id, $answer){
		//echo $answer . "<br>";
		//echo $id . "<br>";
         $result = mysqli_query($this->con, "UPDATE Questionary SET answers ='". $answer ."' WHERE id = '". $id ."'");
    }


   // Compare the answers to the question with the correct answer and return the response for the Result webpage.
   public function results($id){

        $result = mysqli_query($this->con,"SELECT * FROM Questionary WHERE id='". $id ."'");
        $row = mysqli_fetch_array($result);


        $solution = $row['solution'];
        $answer = $row['answers'];
        
        
		// echo $solution . "<br>";
		// echo $answer . "<br>";
		
        if ($solution == $answer){
                 $string = "<p>Question: " .$id. " - Correct: 10 Points <p>";

        }else{
                 $string = "<p>Question: " .$id. " - Wrong: 0 Points <p>"; 
        }
      
        return $string;  // data for template
   }
}

?>
