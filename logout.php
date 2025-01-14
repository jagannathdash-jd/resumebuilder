<?php
session_start();

// Destroy all session data to log the user out
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Optionally, you can also remove the session cookie to ensure complete logout across browsers
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect to the login page
header("Location: login.php");
exit();
