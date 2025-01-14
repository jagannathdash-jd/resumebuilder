<?php
session_start();
include '../include/db.php';
include '../include/function.php';

redirectIfNotLoggedIn();
checkAdminPermission();

$user_query = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
$users = [];

while ($user = $user_query->fetch_assoc()) {
    $users[] = $user;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
    <h1>Manage Users</h1>
    <nav>
        <a href="index.php">Dashboard</a>
        <a href="analytics.php">Analytics</a>
        <a href="../logout.php">Logout</a>
    </nav>
</header>

<section class="admin-users">
    <h2>All Users</h2>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> | 
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
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
