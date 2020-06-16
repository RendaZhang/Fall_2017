<?php
ini_set('display_errors','1');
error_reporting(E_ALL);

$con = mysqli_connect('cse-curly.cse.umn.edu','F17CS4131F16Uxxx','xxxxx','F174131F16Uxxx','3306');
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit(1);
  }

// Create table: // id number correspond to question number
$sql="CREATE TABLE Questionary(id INT NOT NULL AUTO_INCREMENT,
      solution VARCHAR(20), 
      answers VARCHAR(20),
      PRIMARY KEY (id));";

// Execute query
if (mysqli_query($con,$sql))
  {
  echo "<h1> Table myQuiz created successfully </h1>";
  }
else
  {
  echo "<h1> Error creating table: <h1>" . mysqli_error($con);
  }

mysqli_close($con);

?> 
