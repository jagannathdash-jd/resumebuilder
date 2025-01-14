<?php
include 'includes/db.php';
include 'includes/function.php';
include 'includes/header.php';
include 'includes/footer.php';

// Validate the 'id' parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid resume ID!");
}

$id = (int) $_GET['id'];

// Check database connection
if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

// Fetch the student details using a prepared statement
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Resume not found!");
}

$data = $result->fetch_assoc();

// Assign values to variables for the template
$student_name = $data['name'] ?? 'Not Available';
$student_profession = $data['portfolio'] ?? 'Not Provided'; // Change this if profession is stored separately
$student_email = $data['email'] ?? 'Not Provided';
$student_phone = $data['phone'] ?? 'Not Provided';

// Handle education and skills (check if they are JSON or comma-separated)
$education = json_decode($data['education'], true);
if ($education === null) {  // If JSON decoding fails, assume CSV format
    $education = explode(',', $data['education']);
}

$skills = json_decode($data['skills'], true);
if ($skills === null) {  // If JSON decoding fails, assume CSV format
    $skills = explode(',', $data['skills']);
}

// Trim whitespace from array values
$education = array_map('trim', $education);
$skills = array_map('trim', $skills);

// Ensure template file exists
$template_path = "templates/" . basename($data['template']) . ".php";
if (!file_exists($template_path)) {
    die("Template not found! (Checked path: $template_path)");
}

// Include the template
include $template_path;

$stmt->close();
?>
