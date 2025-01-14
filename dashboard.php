<?php
session_start();
include 'includes/db.php';
include 'includes/function.php';
include 'includes/header.php';
include 'includes/footer.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details with prepared statement
$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

// Fetch user resume details
$resume_query = $conn->prepare("SELECT * FROM students WHERE user_id = ?");
$resume_query->bind_param("i", $user_id);
$resume_query->execute();
$resume_result = $resume_query->get_result();
$resume = $resume_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ResumeBuilder</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
    <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
    <nav>
        <a href="create.php">Create/Edit Resume</a>
        <?php if ($resume): ?>
            <a href="preview.php?id=<?php echo $resume['id']; ?>">View Resume</a>
            <a href="export_pdf.php?id=<?php echo $resume['id']; ?>">Download PDF</a>
            <a href="export_word.php?id=<?php echo $resume['id']; ?>">Download Word</a>
            <a href="analytics.php">Resume Analytics</a>
            <a href="jobs.php">Job Matching</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<section class="dashboard">
    <h2>Your Dashboard</h2>
    
    <?php if ($resume): ?>
        <div class="resume-info">
            <h3>Your Resume Details</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($resume['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($resume['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($resume['phone']); ?></p>
            <p><strong>LinkedIn:</strong> <a href="<?php echo htmlspecialchars($resume['linkedin']); ?>" target="_blank"><?php echo htmlspecialchars($resume['linkedin']); ?></a></p>
            <p><strong>GitHub:</strong> <a href="<?php echo htmlspecialchars($resume['github']); ?>" target="_blank"><?php echo htmlspecialchars($resume['github']); ?></a></p>
            <p><strong>Template:</strong> <?php echo ucfirst(htmlspecialchars($resume['template'])); ?></p>
            <p><strong>Resume Views:</strong> <?php echo htmlspecialchars($resume['views']); ?></p>
            <p><strong>Downloads:</strong> <?php echo htmlspecialchars($resume['downloads']); ?></p>
        </div>
    <?php else: ?>
        <p>You haven't created a resume yet.</p>
        <a href="create.php" class="btn">Create Resume</a>
    <?php endif; ?>
</section>

<footer>
    <p>&copy; 2025 ResumeBuilder. All Rights Reserved.</p>
</footer>

</body>
</html>
