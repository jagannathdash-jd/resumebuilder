<?php
session_start();
include '../includes/db.php';
include '../includes/function.php';

redirectIfNotLoggedIn();
checkAdminPermission();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
    <nav>
        <a href="manage_resume.php">Manage Resumes</a>
        <a href="manage_job.php">Manage Jobs</a>
        <a href="manage_user.php">Manage Users</a>
        <a href="analytics.php">Analytics</a>
        <a href="../logout.php">Logout</a>
    </nav>
</header>

<section class="admin-dashboard">
    <h2>Welcome, Admin!</h2>
    <p>Use the navigation menu to manage the system.</p>
</section>

<footer>
    <p>&copy; 2025 ResumeBuilder. All Rights Reserved.</p>
</footer>

</body>
</html>
