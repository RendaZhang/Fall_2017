<?php
if(empty($_SESSION)) {
  header('Location: login.php');
  exit;
} else {
  include_once('database_HW6F17.php');
  // create connection
  $conn = new mysqli($db_servername,$db_username,$db_password,$db_name,$db_port);
  // check for connection error
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $squery = "SELECT * FROM tbl_accounts WHERE acc_login = '" .
            $_SESSION["acc_login"] . "';";
  // get the result from query then close the connection
  $result = $conn->query($squery);
  $conn->close();
  $row = $result->fetch_assoc();
  $password = $row["acc_password"];

  if (($password != $_SESSION["acc_password"]) or (!isset($password))) {
    header('Location: login.php');
    exit;
  }
}
?>
