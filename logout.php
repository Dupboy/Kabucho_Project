<?php
session_start(); // Start the session to access session data
session_destroy(); // Destroy all session data to log the user out
header("Location: login.php"); // Redirect to the login page
exit; // Stop further script execution
?>
