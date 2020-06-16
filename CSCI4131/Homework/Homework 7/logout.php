<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="description" content="Homework 6">
   <meta name="author" content="Renda Zhang">
   <meta name="class" content="CSci4131">
</head>
<body>

<?php
// clear all session variables
session_unset();
// destroy the session
session_destroy();

header('Location: login.php');
exit;
?>

</body>
</html>
