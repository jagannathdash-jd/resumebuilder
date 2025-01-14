<?php
session_start();
include 'includes/db.php';
include 'includes/function.php';

// Redirect to login if not logged in
redirectIfNotLoggedIn();

// Get the user ID
$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize user input
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $linkedin = sanitizeInput($_POST['linkedin']);
    $github = sanitizeInput($_POST['github']);
    $portfolio = isset($_POST['portfolio']) ? sanitizeInput($_POST['portfolio']) : ''; // Default to empty string
    $education = isset($_POST['education']) ? sanitizeInput($_POST['education']) : ''; // Default to empty string
    $experience = isset($_POST['experience']) ? sanitizeInput($_POST['experience']) : ''; // Default to empty string
    $skills = sanitizeInput($_POST['skills']);
    $template = 'simple';  // Default template, can be dynamic based on user selection
    $theme_color = '#000000';  // Default color

    // Handle profile photo upload (optional)
    $profile_photo = null;
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        // Check if the file upload is successful
        $profile_photo = uploadProfilePhoto($_FILES['profile_photo']);
        if ($profile_photo === false) {
            // If upload failed, show error and exit
            echo "Error uploading profile photo.";
            exit();
        }
    }

    // Prepare query to check if resume already exists for this user
    $stmt = $conn->prepare("SELECT * FROM students WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $resume_query = $stmt->get_result();

    if ($resume_query->num_rows > 0) {
        // Resume already exists, update it
        $resume_data = $resume_query->fetch_assoc();
        $resume_id = $resume_data['id'];

        // If no new profile photo is uploaded, keep the old one
        if ($profile_photo === null) {
            $profile_photo = $resume_data['profile_photo']; // Keep the existing photo
        }

        // Prepare the update query
        $update_stmt = $conn->prepare("UPDATE students SET 
                    name = ?, 
                    email = ?, 
                    phone = ?, 
                    linkedin = ?, 
                    github = ?, 
                    portfolio = ?, 
                    education = ?, 
                    experience = ?, 
                    skills = ?, 
                    template = ?, 
                    theme_color = ?, 
                    profile_photo = ? 
                    WHERE id = ?");
        
        // Bind the parameters correctly
        $update_stmt->bind_param("sssssssssssss", $name, $email, $phone, $linkedin, $github, $portfolio, $education, $experience, $skills, $template, $theme_color, $profile_photo, $resume_id);

        if ($update_stmt->execute()) {
            // Redirect to the preview page after successful update
            header("Location: preview.php?id=" . $resume_id);
            exit();
        } else {
            echo "Error updating resume: " . $update_stmt->error;
        }
    } else {
        // Insert new resume for this user
        $public_id = uniqid('resume_'); // Unique identifier for the resume

        // If no profile photo is provided, set default
        if ($profile_photo === null) {
            $profile_photo = 'uploads/photos/default.png'; // Default image or null if allowed
        }

        // Prepare the insert query
        $insert_stmt = $conn->prepare("INSERT INTO students 
                    (user_id, name, email, phone, linkedin, github, portfolio, education, experience, skills, template, theme_color, profile_photo, public_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("isssssssssssss", $user_id, $name, $email, $phone, $linkedin, $github, $portfolio, $education, $experience, $skills, $template, $theme_color, $profile_photo, $public_id);

        if ($insert_stmt->execute()) {
            // Redirect to the preview page after successful resume creation
            header("Location: preview.php?id=" . $user_id);
            exit();
        } else {
            echo "Error creating resume: " . $insert_stmt->error;
        }
    }
}
?>
