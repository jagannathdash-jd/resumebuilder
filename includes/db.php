<?php
$host = "localhost";
$user = "root";  // Change this to your database username
$password = "";  // Change this to your database password
$database = "resumebuilder";

// Connect to the database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
