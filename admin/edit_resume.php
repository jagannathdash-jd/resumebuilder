<?php
session_start();
include '../include/db.php';
include '../include/function.php';

redirectIfNotLoggedIn();
checkAdminPermission();

if (isset($_GET['id'])) {
    $resume_id = intval($_GET['id']);
    $resume_query = $conn->query("SELECT * FROM students WHERE id = '$resume_id'");
    $resume = $resume_query->fetch_assoc();

    if (!$resume) {
        die("Resume not found!");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $resume_title = $_POST['resume_title'];

    $conn->query("UPDATE students SET name='$name', resume_title='$resume_title' WHERE id='$resume_id'");
    header("Location: manage_resume.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Resume</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header><h1>Edit Resume</h1></header>

<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($resume['name']); ?>" required>

    <label>Resume Title:</label>
    <input type="text" name="resume_title" value="<?php echo htmlspecialchars($resume['resume_title']); ?>" required>

    <button type="submit">Update Resume</button>
</form>

<a href="manage_resume.php">Back to Resume Management</a>
</body>
</html>
