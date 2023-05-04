<?php
session_start();

// Unset the session variable
unset($_SESSION['loggedin']);

// Redirect the user to the login page
header('Location: login.php');
exit;
?>
