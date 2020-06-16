<?php
session_start();
?>

<?php
include('session.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
		<meta charset="UTF-8">
    <meta name="description" content="Homework 6">
		<meta name="author" content="Renda Zhang">
    <meta name="class" content="CSci4131">
		<link rel="stylesheet" href="style.css">
    <title>Calendar Input</title>
  </head>
  <body>
    <div id="logout">
      <?php
      $username = $_SESSION["acc_login"];
      echo 'Welcome ' . $username;
      ?>
      <form method="post" action="logout.php">
        <p>
    			<input type = "submit" value = "Log Out">
    		</p>
      </form>
    </div>

	<h1>Calendar Input</h1>
	<nav id="navmenu">
	<ul>
	<li><a href="calendar.php">Calendar</a></li>
	<li><a href="form.php">Input</a></li>
  <li><a href="admin.php">Admin</a></li>
	</ul>
	</nav>

  <?php
  // check if $_POST is empty
  if(!empty($_POST)) {
    $filename = "calendar.txt";
    // delete the file if clear button is set
    if(isset($_POST['Clear'])) {
      unlink($filename);
      header('Location: calendar.php');
    } else {
      // checking for empty input error
      $empErr = '';
      if(empty($_POST[eventname])) {
        $empErr = $empErr . "Please provide a value for Event Name.<br/>";
      }
      if(empty($_POST[starttime])) {
        $empErr = $empErr . "Please select a value for Start Time.<br/>";
      }
      if(empty($_POST[endtime])) {
        $empErr = $empErr . "Please enter a value for Event End Time.<br/>";
      }
      if(empty($_POST[location])) {
        $empErr = $empErr . "Please enter a value for Event Location.<br/>";
      }
      // if any input is empty, shown the error without doing anything
      if(!empty($empErr)) {
        $empErr = '<div style="color:red">' . $empErr . '</div>';
        echo $empErr;
      } else { // if input is valid, process to do something
        // a class used to enclosed event
        class Event {
          public $en = "";
          public $st = "";
          public $et = "";
          public $lc = "";
        }
        $event = new Event;
        $event->en = $_POST[eventname];
        $event->st = $_POST[starttime];
        $event->et = $_POST[endtime];
        $event->lc = $_POST[location];
        // Get the file size
        $filesize = filesize($filename);
        if($filesize) { // non-empty file
          $myJson = file_get_contents($filename);
          $myArray = json_decode($myJson);
          array_push($myArray->$_POST[day], $event);
          // sort the array base on starttime st
          function my_sort($a, $b) {
            $x = strtotime($a->st);
            $y = strtotime($b->st);
            if ($x==$y) return 0;
            return ($x<$y)?-1:1;
          }
          usort($myArray->$_POST[day], "my_sort");
          file_put_contents($filename, json_encode($myArray));
          header('Location: calendar.php');
        } else { // empty file
          $myArray->Mon = array();
          $myArray->Tue = array();
          $myArray->Wed = array();
          $myArray->Thur = array();
          $myArray->Fri = array();
          $myArray->$_POST[day] = array($event);
          file_put_contents($filename, json_encode($myArray));
          header('Location: calendar.php');
        }
      }
    }
  }
  ?>


	<div>
		<form method = "post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<table class="form">
			<tr>
				<td>Event Name</td>
				<td><input type="text" name="eventname"></td>
			</tr>
			<tr>
				<td>Start Time</td>
				<td><input type="time" name="starttime"></td>
			</tr>
			<tr>
				<td>End Time</td>
				<td><input type="time" name="endtime"></td>
			</tr>
			<tr>
				<td>Location</td>
				<td><input type="text" name="location"></td>
			</tr>
			<tr>
				<td>Day of the week</td>
				<td>
					<select name="day">
						<option value="Mon">Mon</option>
						<option value="Tue">Tue</option>
						<option value="Wed">Wed</option>
						<option value="Thur">Thur</option>
						<option value="Fri">Fri</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><input type="submit" name="Clear" value="Clear"></td>
				<td><input type="submit" name="Submit" value="Submit"></td>
			</tr>
		</table>
		</form>
	</div>
  </body>
</html>
