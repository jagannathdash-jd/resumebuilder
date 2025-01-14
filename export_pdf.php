<?php
session_start();
include 'db.php';
require_once('tcpdf/tcpdf.php');

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

        // Create PDF using TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Title
        $pdf->Cell(0, 10, 'Resume - ' . $resume_data['name'], 0, 1, 'C');
        
        // Personal Information
        $pdf->Ln(5);
        $pdf->Cell(0, 10, 'Name: ' . $resume_data['name'], 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . $resume_data['email'], 0, 1);
        $pdf->Cell(0, 10, 'Phone: ' . $resume_data['phone'], 0, 1);
        $pdf->Cell(0, 10, 'LinkedIn: ' . $resume_data['linkedin'], 0, 1);
        $pdf->Cell(0, 10, 'GitHub: ' . $resume_data['github'], 0, 1);

        // Add a section for work experience
        $pdf->Ln(10);
        $pdf->Cell(0, 10, 'Work Experience', 0, 1, 'L');
        $pdf->Cell(0, 10, 'Company: ' . $resume_data['company'], 0, 1);
        $pdf->Cell(0, 10, 'Role: ' . $resume_data['role'], 0, 1);
        $pdf->Cell(0, 10, 'Duration: ' . $resume_data['duration'], 0, 1);

        // Add education section
        $pdf->Ln(10);
        $pdf->Cell(0, 10, 'Education', 0, 1, 'L');
        $pdf->Cell(0, 10, 'Degree: ' . $resume_data['degree'], 0, 1);
        $pdf->Cell(0, 10, 'Institution: ' . $resume_data['institution'], 0, 1);

        // Output the PDF to the browser
        $pdf->Output('resume_' . $resume_data['public_id'] . '.pdf', 'D');
        exit();
    } else {
        echo "Resume not found.";
    }
} else {
    echo "Invalid request.";
}
?>
