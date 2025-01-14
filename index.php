<?php
session_start();
include 'includes/header.php';
include 'includes/footer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResumeBuilder - Create Professional Resumes</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>ResumeBuilder</h1>
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" aria-label="Go to Dashboard">Dashboard</a>
                    <a href="logout.php" aria-label="Logout">Logout</a>
                <?php else: ?>
                    <a href="login.php" aria-label="Login to your account">Login</a>
                    <a href="register.php" aria-label="Create a new account">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h2>Build a Professional Resume in Minutes</h2>
            <p>Choose a template, enter your details, and download your resume instantly!</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="btn">Get Started</a>
            <?php else: ?>
                <a href="dashboard.php" class="btn">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>Why Use ResumeBuilder?</h2>
            <div class="feature-item">
                <h3>🚀 Multiple Templates</h3>
                <p>Choose from a variety of professional resume templates.</p>
            </div>
            <div class="feature-item">
                <h3>🎨 Customizable Designs</h3>
                <p>Modify colors, sections, and styles to fit your needs.</p>
            </div>
            <div class="feature-item">
                <h3>📄 Export as PDF & Word</h3>
                <p>Download your resume instantly in multiple formats.</p>
            </div>
            <div class="feature-item">
                <h3>💼 Job Matching</h3>
                <p>Get job recommendations based on your skills.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2025 ResumeBuilder. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
