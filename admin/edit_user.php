<?php
session_start();
include '../include/db.php';
include '../include/function.php';

redirectIfNotLoggedIn();
checkAdminPermission();

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $user_query = $conn->query("SELECT * FROM users WHERE id = '$user_id'");
    $user = $user_query->fetch_assoc();

    if (!$user) {
        die("User not found!");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $conn->query("UPDATE users SET name='$name', email='$email', role='$role' WHERE id='$user_id'");
    header("Location: manage_user.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header><h1>Edit User</h1></header>

<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

    <label>Role:</label>
    <select name="role">
        <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
        <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
    </select>

    <button type="submit">Update User</button>
</form>

<a href="manage_user.php">Back to User Management</a>
</body>
</html>
