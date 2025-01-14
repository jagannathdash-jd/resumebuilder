<?php
session_start();
include '../include/db.php';
include '../include/function.php';

redirectIfNotLoggedIn();
checkAdminPermission();

$job_query = $conn->query("SELECT * FROM jobs ORDER BY created_at DESC");
$jobs = [];

while ($job = $job_query->fetch_assoc()) {
    $jobs[] = $job;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
    <h1>Manage Job Listings</h1>
    <nav>
        <a href="index.php">Dashboard</a>
        <a href="analytics.php">Analytics</a>
        <a href="add_job.php">Add New Job</a>
        <a href="../logout.php">Logout</a>
    </nav>
</header>

<section class="admin-jobs">
    <h2>All Job Listings</h2>

    <table>
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Company</th>
                <th>Location</th>
                <th>Posted Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?php echo htmlspecialchars($job['title']); ?></td>
                    <td><?php echo htmlspecialchars($job['company']); ?></td>
                    <td><?php echo htmlspecialchars($job['location']); ?></td>
                    <td><?php echo htmlspecialchars(date("Y-m-d", strtotime($job['created_at']))); ?></td>
                    <td>
                        <a href="edit_job.php?id=<?php echo $job['id']; ?>">Edit</a> | 
                        <a href="delete_job.php?id=<?php echo $job['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<footer>
    <p>&copy; 2025 ResumeBuilder. All Rights Reserved.</p>
</footer>

</body>
</html>
