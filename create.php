<?php
session_start();
include 'includes/db.php';
include 'includes/function.php';
include 'includes/header.php';
include 'includes/footer.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Get input data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $linkedin = trim($_POST['linkedin']);
    $github = trim($_POST['github']);
    $portfolio = trim($_POST['portfolio']);
    $education = trim($_POST['education']);
    $experience = trim($_POST['experience']);
    $skills = trim($_POST['skills']);
    $template = trim($_POST['template']);
    $theme_color = trim($_POST['theme_color']);
    $user_id = $_SESSION['user_id'];
    $public_id = uniqid();

    // Validate input
    if (empty($name) || empty($email)) {
        die("Error: Name and Email are required.");
    }

    // Prepare SQL query
    $sql = "INSERT INTO students (user_id, name, email, phone, linkedin, github, portfolio, education, experience, skills, template, theme_color, public_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("issssssssssss", $user_id, $name, $email, $phone, $linkedin, $github, $portfolio, $education, $experience, $skills, $template, $theme_color, $public_id);

        if ($stmt->execute()) {
            header("Location: preview.php?id=" . $conn->insert_id);
            exit();
        } else {
            die("Error executing query: " . $stmt->error);
        }
        $stmt->close();
    } else {
        die("Error preparing query: " . $conn->error);
    }
}
?>

<!-- Resume Creation Form -->
<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone">
    <input type="text" name="linkedin" placeholder="LinkedIn">
    <input type="text" name="github" placeholder="GitHub">
    <input type="text" name="portfolio" placeholder="Portfolio">
    <textarea name="education" placeholder="Education"></textarea>
    <textarea name="experience" placeholder="Experience"></textarea>
    <textarea name="skills" placeholder="Skills"></textarea>
    <select name="template">
        <option value="simple">Simple</option>
        <option value="modern">Modern</option>
    </select>
    <input type="color" name="theme_color" value="#000000">
    <button type="submit">Create Resume</button>
</form>
