<?php
// Removed session_start() here as it's already being called in process.php

// Redirect users if they are not logged in
function redirectIfNotLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
}

// Sanitize input to prevent XSS and SQL Injection
function sanitizeInput($input) {
    global $conn;
    // Trim and escape input for better sanitization
    $input = trim($input);
    
    // If input is empty, return a default value or throw an error
    if (empty($input)) {
        return '';  // Optionally throw an exception or handle error here
    }
    
    return htmlspecialchars(mysqli_real_escape_string($conn, $input));
}

// Fetch user details using prepared statement
function getUserDetails($user_id) {
    global $conn;
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id); // "i" indicates integer parameter type
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fetch resume details using prepared statement
function getResumeDetails($resume_id) {
    global $conn;
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $resume_id); // "i" indicates integer parameter type
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Function to handle profile photo upload
function uploadProfilePhoto($file) {
    // Allowed file types for profile photo
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    
    // Directory where photos will be uploaded
    $upload_dir = 'uploads/photos/';
    
    // Maximum allowed file size (5MB)
    $max_file_size = 5 * 1024 * 1024; // 5MB

    // Check if file type is allowed
    if (!in_array($file['type'], $allowed_types)) {
        return "Error: Invalid file type. Only JPEG, PNG, and GIF are allowed."; // Invalid file type
    }

    // Check if file size is within limit
    if ($file['size'] > $max_file_size) {
        return "Error: File size exceeds the 5MB limit."; // File too large
    }

    // Check if the uploads directory exists and is writable
    if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
        return "Error: Uploads directory is not writable. Please check directory permissions.";
    }

    // Generate a unique file name to avoid overwriting existing files
    $file_name = uniqid('profile_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_path = $upload_dir . $file_name;

    // Attempt to move the uploaded file to the target directory
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        return $file_path; // Return the file path if successful
    }

    return "Error: File upload failed. Please try again."; // Return error if the upload failed
}
function checkAdminPermission() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        // Redirect to login page if the user is not an admin
        header("Location: ../login.php");
        exit();
    }
}
function redirectIfNotLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
}

?>
