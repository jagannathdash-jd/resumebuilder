<?php
// Start session
session_start();

// Set error reporting level (for development only)
// In production, disable error display for security reasons
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);  // Turn off error reporting in production
    ini_set('display_errors', 0); 
}

// Define site URL (modify for deployment)
define("SITE_URL", "http://localhost/resumebuilder/");  // Change this URL for production
?>
