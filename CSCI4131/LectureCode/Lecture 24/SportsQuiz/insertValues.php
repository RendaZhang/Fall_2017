<?php
ini_set('display_errors','1');
error_reporting(E_ALL);

con = mysqli_connect('cse-curly.cse.umn.edu','F17CS4131F16Uxxx','xxxxx','F174131F16Uxxx','3306');
// Check connection
if (mysqli_connect_errno())
  {
  echo 'Failed to connect to MySQL:' . mysqli_connect_error();
  exit(1);
  }

mysqli_query($con,"INSERT INTO Questionary (solution)  VALUES ('Dave Winfield')");

mysqli_query($con,"INSERT INTO Questionary (solution)  VALUES ('Lou Nanne')");

mysqli_query($con,"INSERT INTO Questionary (solution)  VALUES ('7')");

mysqli_close($con);


echo '<h1> Inserted Values Sucessfully into the Table </h1>'
?> 
