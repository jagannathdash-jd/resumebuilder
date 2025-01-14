<?php
session_start();
include '../include/db.php';
include '../include/function.php';

redirectIfNotLoggedIn();
checkAdminPermission();

if (isset($_GET['id'])) {
    $resume_id = intval($_GET['id']);
    $conn->query("DELETE FROM students WHERE id = '$resume_id'");
}

header("Location: manage_resume.php");
exit();
?>
