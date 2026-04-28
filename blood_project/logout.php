<?php
session_start(); // Access the current session
session_destroy(); // Wipe all session data (log the user out)
header("Location: login.php"); // Redirect immediately to the login page
exit();
?>