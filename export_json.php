<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $resume_id = $_GET['id'];

    // Fetch resume data from the database
    $resume_query = $conn->query("SELECT * FROM students WHERE id = '$resume_id'");
    if ($resume_query->num_rows > 0) {
        $resume_data = $resume_query->fetch_assoc();

        // Convert the resume data to JSON format
        $resume_json = json_encode($resume_data, JSON_PRETTY_PRINT);

        // Set headers to download the JSON file
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="resume_' . $resume_data['public_id'] . '.json"');
        
        // Output the JSON data
        echo $resume_json;
        exit();
    } else {
        echo "Resume not found.";
    }
} else {
    echo "Invalid request.";
}
?>
