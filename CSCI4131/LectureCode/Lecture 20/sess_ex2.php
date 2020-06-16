<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>
	<?php
	    if ( isset($_SESSION['user']) && isset($_SESSION['password']) ) {
			// Echo session variables that were set on the previous page
			echo 'User id   ' . $_SESSION['user'] . '<br>';
			echo 'Password   ' . $_SESSION['password'] . '<br>';
			echo 'Session variables are set.';
		}
		else {
			echo 'Session variables are NOT set.';
		}
	?>
</body>
</html>

