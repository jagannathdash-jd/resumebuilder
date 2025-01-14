<?php
session_start();
include 'includes/db.php'; 


// Redirect to dashboard if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password']; // Do not sanitize password, it will be hashed/verified

    // Prepare and execute SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" is for string
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists and verify password
    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid credentials!";
    }
}

// Function to sanitize input
function sanitizeInput($input) {
    global $conn;
    return htmlspecialchars(mysqli_real_escape_string($conn, trim($input)));
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
