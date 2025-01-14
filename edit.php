<?php
session_start();
include 'includes/db.php';
include 'includes/function.php';
include 'includes/header.php';
include 'includes/footer.php';

// Redirect to login if not logged in
redirectIfNotLoggedIn();

// Get the user ID
$user_id = $_SESSION['user_id'];

// Fetch the user's existing resume
$resume_query = $conn->prepare("SELECT * FROM students WHERE user_id = ?");
$resume_query->bind_param("i", $user_id);
$resume_query->execute();
$resume_result = $resume_query->get_result();
$resume = $resume_result->fetch_assoc();

// Check if resume exists
if (!$resume) {
    echo "You need to create a resume first.";
    exit();
}

// Populate the form with existing resume data
$name = isset($resume['name']) ? htmlspecialchars($resume['name']) : '';
$email = isset($resume['email']) ? htmlspecialchars($resume['email']) : '';
$phone = isset($resume['phone']) ? htmlspecialchars($resume['phone']) : '';
$linkedin = isset($resume['linkedin']) ? htmlspecialchars($resume['linkedin']) : '';
$github = isset($resume['github']) ? htmlspecialchars($resume['github']) : '';
$skills = isset($resume['skills']) ? htmlspecialchars($resume['skills']) : '';
$company = isset($resume['company']) ? htmlspecialchars($resume['company']) : '';
$role = isset($resume['role']) ? htmlspecialchars($resume['role']) : '';
$duration = isset($resume['duration']) ? htmlspecialchars($resume['duration']) : '';
$degree = isset($resume['degree']) ? htmlspecialchars($resume['degree']) : '';
$institution = isset($resume['institution']) ? htmlspecialchars($resume['institution']) : '';
$profile_photo = isset($resume['profile_photo']) ? $resume['profile_photo'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resume - ResumeBuilder</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
    <h1>Edit Resume</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<section class="edit-resume">
    <h2>Edit Your Resume</h2>

    <form action="process.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>

        <label for="linkedin">LinkedIn:</label>
        <input type="url" id="linkedin" name="linkedin" value="<?php echo $linkedin; ?>">

        <label for="github">GitHub:</label>
        <input type="url" id="github" name="github" value="<?php echo $github; ?>">

        <label for="skills">Skills (comma separated):</label>
        <input type="text" id="skills" name="skills" value="<?php echo $skills; ?>" required>

        <label for="company">Company:</label>
        <input type="text" id="company" name="company" value="<?php echo $company; ?>">

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?php echo $role; ?>">

        <label for="duration">Duration (e.g., 2018-2022):</label>
        <input type="text" id="duration" name="duration" value="<?php echo $duration; ?>">

        <label for="degree">Degree:</label>
        <input type="text" id="degree" name="degree" value="<?php echo $degree; ?>">

        <label for="institution">Institution:</label>
        <input type="text" id="institution" name="institution" value="<?php echo $institution; ?>">

        <label for="profile_photo">Profile Photo:</label>
        <input type="file" id="profile_photo" name="profile_photo">
        
        <?php if ($profile_photo): ?>
            <p>Current Photo: <img src="<?php echo htmlspecialchars($profile_photo); ?>" alt="Profile Photo" width="100"></p>
        <?php endif; ?>

        <button type="submit">Save Changes</button>
    </form>
</section>

<footer>
    <p>&copy; 2025 ResumeBuilder. All Rights Reserved.</p>
</footer>

</body>
</html>
