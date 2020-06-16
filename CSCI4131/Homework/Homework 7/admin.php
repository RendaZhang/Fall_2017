<?php
session_start();
?>

<?php
include('session.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Users Page</title>
  <link rel="stylesheet" type="text/css" href="style2.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Latest compiled JavaScript -->
  <!-- jQuery library -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css"> <!-- load bootstrap css -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"> <!-- load fontawesome -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
</head>

<body>

  <div class="main">
      <a href="logout.php" class="btn btn-info" style="width:90px"> LogOut </a>
      <h3>
        <?php
          $username = $_SESSION["acc_name"];
          echo 'Welcome ' . $username . '.';
         ?>
      </h3>
      <div>
      <nav>
        <a href="calendar.php" class = "btn btn-info">Calendar</a>
        <a href="form.php" class = "btn btn-info" style="width:90px">Input</a>
        <a href="admin.php" class = "btn btn-info" style="width:90px">Admin</a>
      </nav>
    </div>
    This page is protected from the public, and you can see a list of all users defined in the database.
  </div>

  <p></p>

  <form method="post">
    <div class="main">

      <h1>List of Users</h1>

      <div style="color:red">
      <?php
        include_once('database_HW6F17.php');

        // create connection
        $conn = new mysqli($db_servername,$db_username,$db_password,$db_name,$db_port);
        // check for connection error
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // if user click on the Add User button
        if (isset($_POST['add'])) {
          // check for empty error
          if (empty($_POST[name_0])) {
            echo "Please enter a valid value for name.<br><br>";
          } else if (empty($_POST[login_0])) {
            echo "Please enter a valid value for login.<br><br>";
          } else if (empty($_POST[password_0])) {
            echo "Please enter a valid value for password.<br><br>";
          } else {
            // query to get the row in DB with the same acc_login
            $login_query = "SELECT acc_login FROM tbl_accounts WHERE " .
              "acc_login = '" . $_POST[login_0] . "';";
            $result = $conn->query($login_query);

            // check if the login is unique
            if ($result->num_rows > 0) {
              echo "This login is used by another user.<br><br><br>";
            } else {
              // build INSERT query
              $iquery = "INSERT INTO tbl_accounts " .
                        "(acc_name, acc_login, acc_password) VALUES " .
                        "('" . $_POST[name_0] . "', '" . $_POST[login_0] .
                        "', '" . sha1($_POST[password_0]) . "');";

              // check for query error
              if ($conn->query($iquery) === TRUE) {
                echo "Account added successfully.<br><br><br>";
              } else {
                echo "Error: " . $iquery . "<br>" . $conn->error;
              }
            }
          }
        }

        // if user click on the Delete User button
        if (isset($_POST['delete'])) {
          // build DELETE query
          $dquery = "DELETE FROM tbl_accounts WHERE acc_id = " .
                    $_POST['delete'] . ";";

          // check fr query error
          if ($conn->query($dquery) === TRUE) {
            echo "Account deleted successfully.<br><br><br>";
          } else {
            echo "Error deleting record" . $conn->error;
          }
        }

        $update_failed = TRUE;
        // if user click on the Update button
        if (isset($_POST['update'])) {
          $name = "name_" . $_POST['update'];
          $login = "login_" . $_POST['update'];
          $password = "password_" . $_POST['update'];
          // check for empty error
          if (empty($_POST[$name])) {
            echo "Please enter a valid value for name.<br><br>";
          } else if (empty($_POST[$login])) {
            echo "Please enter a valid value for login.<br><br>";
          } else if (empty($_POST[$password])) {
            echo "Please enter a valid value for password.<br><br>";
          } else {
            // query to get row with the same acc_login other than itself
            $login_query = "SELECT acc_login FROM tbl_accounts WHERE " .
              "acc_login = '" . $_POST[$login] . "' AND (acc_id <> " .
              $_POST['update'] . ") LIMIT 1;";
            $result = $conn->query($login_query);

            // check if the login is unique
            if ($result->num_rows > 0) {
              echo "This login is used by another user.<br><br><br>";
            } else {
              $update_failed = FALSE;
              // build UPDATE query
              $uquery = "UPDATE tbl_accounts SET acc_name='" . $_POST[$name] .
                        "', acc_login='" . $_POST[$login] .
                        "', acc_password='" . sha1($_POST[$password]) .
                        "' WHERE acc_id='" . $_POST['update'] . "';";
              // check for query error
              if ($conn->query($uquery) === TRUE) {
                echo "Account updated successfully.<br><br><br>";
              } else {
                echo "Error: " . $uquery . "<br>" . $conn->error;
              }
            }
          }
        }

        // build SELECT query order by the account name
        $squery = "SELECT * FROM tbl_accounts ORDER BY acc_name;";
        // get the result from query then close the connection
        $result = $conn->query($squery);
        // Build up the Table for the list of users
        $output = '<tr> <th>ID</th> <th>Name</th> <th>Login</th> ' .
                  '<th>New Password</th> <th>Action</th></tr>';
        while($row = $result->fetch_assoc()) {
          // If user click on the Edit button
          if ((isset($_POST['edit'])) && ($_POST['edit'] == $row["acc_id"])) {
            $output = $output . '<tr> <td>' . $row["acc_id"] . '</td> ';
            $output = $output . '<td><input type="text" name="name_' .
                      $row["acc_id"] . '" value="' . $row["acc_name"] .
                      '" size="11"></td>';
            $output = $output . '<td><input type="text" name="login_' .
                      $row["acc_id"] . '" value="' . $row["acc_login"] .
                      '" size="5"></td>';
            $output = $output . '<td><input type="text" name="password_' .
                      $row["acc_id"] . '" value=""  size="11"></td>';
            $output = $output .
                      '<td><button name="update" value="' . $row["acc_id"] .
                      '">Update</button>  ' .
                      '<button name="cancel" value="' . $row["acc_id"] .
                      '">Cancel</button></td>';
            $output = $output . '</tr>';
          }
          // else if user click on the update button
          else if ((isset($_POST['update'])) && $update_failed
                    && ($_POST['update'] == $row["acc_id"])) {
            // get all the value from the previous table
            $name = "name_" . $_POST['update'];
            $login = "login_" . $_POST['update'];
            $password = "password_" . $_POST['update'];

            // keep the row as it was
            $output = $output . '<tr> <td>' . $row["acc_id"] . '</td> ';
            $output = $output . '<td><input type="text" name="name_' .
                      $row["acc_id"] . '" value="' . $_POST[$name] .
                      '" size="11"></td>';
            $output = $output . '<td><input type="text" name="login_' .
                      $row["acc_id"] . '" value="' . $_POST[$login] .
                      '" size="5"></td>';
            $output = $output . '<td><input type="text" name="password_' .
                      $row["acc_id"] . '" value="' . $_POST[$password] .
                      '"  size="11"></td>';
            $output = $output .
                      '<td><button name="update" value="' . $row["acc_id"] .
                      '">Update</button>  ' .
                      '<button name="cancel" value="' . $row["acc_id"] .
                      '">Cancel</button></td>';
            $output = $output . '</tr>';
          }
          else {
            $output = $output . '<tr> <td>' . $row["acc_id"] . '</td> ';
            $output = $output . '<td>' . $row["acc_name"] . '</td> ';
            $output = $output . '<td>' . $row["acc_login"] . '</td> ';
            $output = $output . '<td></td> ';
            $output = $output . '<td>' .
                      '<button name="edit" value="' . $row["acc_id"] .
                      '">Edit</button>  ' .
                      '<button name="delete" value="' . $row["acc_id"] .
                      '">Delete</button></td>';
            $output = $output . '</tr>';
          }
        }
        $output = '<table class="grid">' . $output . '</table>';
      ?>

      </div>

      <?php
        echo $output;
        // close the connection
        $conn->close();
      ?>

    </div>

    <p></p>

    <div class="main">
      <h1>Add New User</h1>
      <label for="name_0">Name: </label>
      <input type="text" name="name_0" value="" />
      <br /><br />
      <label for="login_0">Login: </label>
      <input type="text" name="login_0" value="" />
      <br /><br />
      <label for="password_0">Password: </label>
      <input type="text" name="password_0" value="" />
      <br /><br />
      <button name="add" value="add">Add User</button>
    </div>
  </form>

</body>
</html>
