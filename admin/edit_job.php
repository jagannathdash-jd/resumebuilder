<?php
session_start();
include '../include/db.php';
include '../include/function.php';

redirectIfNotLoggedIn();
checkAdminPermission();

if (isset($_GET['id'])) {
    $job_id = intval($_GET['id']);
    $job_query = $conn->query("SELECT * FROM jobs WHERE id = '$job_id'");
    $job = $job_query->fetch_assoc();

    if (!$job) {
        die("Job not found!");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $company = $_POST['company'];
    $location = $_POST['location'];

    $conn->query("UPDATE jobs SET title='$title', company='$company', location='$location' WHERE id='$job_id'");
    header("Location: manage_job.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header><h1>Edit Job</h1></header>

<form method="POST">
    <label>Job Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required>

    <label>Company:</label>
    <input type="text" name="company" value="<?php echo htmlspecialchars($job['company']); ?>" required>

    <label>Location:</label>
    <input type="text" name="location" value="<?php echo htmlspecialchars($job['location']); ?>" required>

    <button type="submit">Update Job</button>
</form>

<a href="manage_job.php">Back to Job Management</a>
</body>
</html>
