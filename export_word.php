<?php
session_start();
include 'db.php';
require_once 'vendor/autoload.php'; // Make sure PHPWord is installed via Composer

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

        // Create a new Word document using PHPWord
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        // Title
        $section->addText('Resume - ' . $resume_data['name'], array('size' => 16, 'bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

        // Personal Information
        $section->addText('Name: ' . $resume_data['name']);
        $section->addText('Email: ' . $resume_data['email']);
        $section->addText('Phone: ' . $resume_data['phone']);
        $section->addText('LinkedIn: ' . $resume_data['linkedin']);
        $section->addText('GitHub: ' . $resume_data['github']);

        // Work Experience
        $section->addText('Work Experience', array('bold' => true));
        $section->addText('Company: ' . $resume_data['company']);
        $section->addText('Role: ' . $resume_data['role']);
        $section->addText('Duration: ' . $resume_data['duration']);

        // Education
        $section->addText('Education', array('bold' => true));
        $section->addText('Degree: ' . $resume_data['degree']);
        $section->addText('Institution: ' . $resume_data['institution']);

        // Output the Word document
        $fileName = 'resume_' . $resume_data['public_id'] . '.docx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        
        $phpWord->save('php://output');

        exit();
    } else {
        echo "Resume not found.";
    }
} else {
    echo "Invalid request.";
}
?>
