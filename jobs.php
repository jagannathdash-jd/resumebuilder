<?php
session_start();
include 'includes/db.php';
include 'includes/function.php';
include 'includes/header.php';
include 'includes/footer.php';
// Redirect to login if not logged in
redirectIfNotLoggedIn();

// Get user ID
$user_id = $_SESSION['user_id'];

// Fetch user resume details using a prepared statement
$stmt = $conn->prepare("SELECT * FROM students WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resume_query = $stmt->get_result();
$resume = $resume_query->fetch_assoc();

// Check if resume exists
if (!$resume) {
    echo "You need to create a resume first.";
    exit();
}

// Get skills from the resume (assuming 'skills' field exists in the resume data)
$skills = $resume['skills'];

// Fetch job suggestions based on the skills
$jobs = getJobSuggestions($conn, $skills);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Matching - ResumeBuilder</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
    <h1>Job Matching</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<section class="job-matching">
    <h2>Job Suggestions Based on Your Skills</h2>

    <?php if ($jobs && count($jobs) > 0): ?>
        <ul>
            <?php foreach ($jobs as $job): ?>
                <li>
                    <h3><?php echo htmlspecialchars($job['job_title']); ?></h3>
                    <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                    <p><strong>Skills Required:</strong> <?php echo htmlspecialchars($job['skills']); ?></p>
                    <p><a href="apply.php?job_id=<?php echo $job['id']; ?>" class="apply-link">Apply Now</a></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No job matches found based on your skills. Please update your resume with more specific skills.</p>
    <?php endif; ?>
</section>

<footer>
    <p>&copy; 2025 ResumeBuilder. All Rights Reserved.</p>
</footer>

</body>
</html>

