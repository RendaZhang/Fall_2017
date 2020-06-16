<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>
	<?php
		// Set session variables
		$_SESSION['user'] = 'Dan';
		$_SESSION['password'] = 'blech502!';
		echo 'Session variables are set.';
	?>
</body>
</html>

