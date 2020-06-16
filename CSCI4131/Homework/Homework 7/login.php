<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
 <head>
		<meta charset="UTF-8">
		<meta name="description" content="Homework 6">
		<meta name="author" content="Renda Zhang">
    <meta name="class" content="CSci4131">
		<link rel="stylesheet" href="style.css">
   <title>Login Page</title>
 </head>
 <body>
	<h1>Login Page</h1>

  <?php
  include_once('database_HW6F17.php');

  // build SELECT query
  $squery = "SELECT * FROM tbl_accounts;";
  // create connection
  $conn = new mysqli($db_servername,$db_username,$db_password,$db_name,$db_port);
  // check for connection error
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  // get the result from query then close the connection
  $result = $conn->query($squery);
  $conn->close();

  // check if $_POST is empty
  if(!empty($_POST)) {
    // checking for empty input error
    $empErr = '';
    $username = $_POST[username];
    $password = $_POST[password];
    if(empty($username)) {
      $empErr = $empErr . "Please enter a valid value for Login Name Field.<br/>";
    }
    if(empty($password)) {
      $empErr = $empErr . "Please enter a valid value for Password Field.";
    }
    // if any input is empty, shown the error without doing anything
    if(!empty($empErr)) {
      $empErr = '<div style="color:red">' . $empErr . '</div>';
      echo $empErr;
    }
    else { // if input is valid, process to do something

      if ($result->num_rows == 0) {
        exit("database tbl_accounts is empty");
      }

      // loop through the query result
      $acc_name = '';
      $acc_password = '';
      $acc_login = '';
      while($row = $result->fetch_assoc()) {
        if ($row["acc_login"] == $username) {
          $acc_name = $row["acc_name"];
          $acc_login = $row["acc_login"];
          $acc_password = $row["acc_password"];
          break;
        }
      }

      // check for password and username error
      if (empty($acc_login)) {
        echo '<div style="color:red">Login is incorrect: User does not exist.' .
             'Please check the login details and try again.</div>';
      } else {
        // encryt the password for comparison
        $sha1word = sha1($password);
        if($acc_password == $sha1word) {
          $_SESSION["acc_name"] = $acc_name;
          $_SESSION["acc_login"] = $acc_login;
          $_SESSION["acc_password"] = $acc_password;
          header('Location: calendar.php');
          exit;
        } else {
          echo '<div style="color:red">Password is incorrect: ' .
               'Please check the password and try again.</div>';
        }
      }
    }
  }
  ?>

  <div id="reminder">Please enter your user's login name and password. Both values are case sensitive</div>
	<div>
		<form method = "post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table>
			<tr>
				<td>Login:</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
        <td></td>
				<td><input type="submit" name="Submit" value="Submit"></td>
			</tr>
		</table>
		</form>
	</div>
 </body>
</html>
