<?php
session_start();
include 'includes/db.php';
include 'includes/function.php';
include 'includes/header.php';
include 'includes/footer.php';

// Redirect to login if not logged in
redirectIfNotLoggedIn();

// Check if the user is an admin
$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

if ($user['role'] !== 'admin') {
    echo "You don't have permission to access this page.";
    exit();
}

// Fetch resume analytics from the database
$resume_query = $conn->query("SELECT * FROM students");

$resumes = [];
$views = 0;
$downloads = 0;

while ($resume = $resume_query->fetch_assoc()) {
    $resumes[] = $resume;
    $views += (int)$resume['views'];
    $downloads += (int)$resume['downloads'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - ResumeBuilder</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
    <h1>Resume Analytics</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<section class="analytics">
    <h2>Overview</h2>
    <p><strong>Total Resumes:</strong> <?php echo count($resumes); ?></p>
    <p><strong>Total Views:</strong> <?php echo $views; ?></p>
    <p><strong>Total Downloads:</strong> <?php echo $downloads; ?></p>

    <h2>Resume Statistics</h2>
    <table>
        <thead>
            <tr>
                <th>Resume Name</th>
                <th>Views</th>
                <th>Downloads</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($resumes) > 0): ?>
                <?php foreach ($resumes as $resume): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($resume['name']); ?></td>
                        <td><?php echo htmlspecialchars($resume['views']); ?></td>
                        <td><?php echo htmlspecialchars($resume['downloads']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No resumes found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<footer>
    <p>&copy; 2025 ResumeBuilder. All Rights Reserved.</p>
</footer>

</body>
</html>
