<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Builder</title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/style.css">
</head>
<body>
<header>
    <h1>Resume Builder</h1>
    <nav>
        <a href="<?php echo SITE_URL; ?>">Home</a>
        <a href="<?php echo SITE_URL; ?>dashboard.php">Dashboard</a>
        <a href="<?php echo SITE_URL; ?>jobs.php">Jobs</a>
        <a href="<?php echo SITE_URL; ?>logout.php">Logout</a>
    </nav>
</header>
