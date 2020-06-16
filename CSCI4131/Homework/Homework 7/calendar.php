<?php
session_start();
?>

<?php
include('session.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="Homework 6">
    <meta name="author" content="Renda Zhang">
    <meta name="class" content="CSci4131">
    <title>Daily Calendar</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  	<script type="text/javascript"
      src = "https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAySb0zZLtwQnzFhJwqtTwVDRoU-lJa1ok">
  	</script>
    <script src="calendar.js"></script>
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

  <h1>My Calendar</h1>
  <nav id="navmenu">
    <ul>
    <li><a href="calendar.php">Calendar</a></li>
    <li><a href="form.php">Input</a></li>
    <li><a href="admin.php">Admin</a></li>
    </ul>
  </nav>
  <div id="calendar">
    <?php
      $filename = "calendar.txt";
      $filesize = filesize($filename);
      if($filesize) {
        $myJson = file_get_contents($filename);
        $myArray = json_decode($myJson);
        $output = '';
        // loop through associative array with day as key
        foreach($myArray as $day => $events) {
          // access the events in the day and concatenate the html output
          if(!empty($events)) {
            $output = $output . '<td>' . $day . '</td>';
            foreach($events as $event) {
              $output = $output . '<td><p><i>' . $event->st . ' - ' .
                        $event->et . '</i></p>' . $event->en . '- ' .
                        '<span class="loc">' . $event->lc . '</span></td>';
            }
            $output = '<tr>' . $output . '</tr>';
          }
        }
        $output = '<table>' . $output . '</table>';
        echo $output;
      } else {
        echo('<br><div style="color:red">' . 'Calendar has no events. ' .
        'Please use the input page to enter some events.</div><br>');
      }
    ?>
  </div>

  <form id="loc_form" onSubmit="RformEvent(); return false;">
    <p>
			<label>Radius:</label>
			<input id = "location_box" type="number" min="500" max="10000"
				required="required">
			<input id="load_marks" type = "submit" value = "Find Nearby Resturants">
		</p>
  </form>

  <br>
  <div id="map-canvas"></div>

  <p>This page has been tested in Firefox.</p>
  </body>
</html>
