<?php
session_start();
include '../include/db.php';
include '../include/function.php';

redirectIfNotLoggedIn();
checkAdminPermission();

$resume_query = $conn->query("SELECT students.*, users.email FROM students JOIN users ON students.user_id = users.id");
$resumes = [];

while ($resume = $resume_query->fetch_assoc()) {
    $resumes[] = $resume;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resumes</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
    <h1>Manage Resumes</h1>
    <nav>
        <a href="index.php">Dashboard</a>
        <a href="analytics.php">Analytics</a>
        <a href="../logout.php">Logout</a>
    </nav>
</header>

<section class="admin-resumes">
    <h2>All User Resumes</h2>

    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Resume Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resumes as $resume): ?>
                <tr>
                    <td><?php echo htmlspecialchars($resume['name']); ?></td>
                    <td><?php echo htmlspecialchars($resume['email']); ?></td>
                    <td><?php echo htmlspecialchars($resume['resume_title']); ?></td>
                    <td>
                        <a href="edit_resume.php?id=<?php echo $resume['id']; ?>">Edit</a> | 
                        <a href="delete_resume.php?id=<?php echo $resume['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
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
