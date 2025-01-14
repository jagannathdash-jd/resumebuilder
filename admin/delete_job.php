<?php
session_start();
include '../include/db.php';
include '../include/function.php';

redirectIfNotLoggedIn();
checkAdminPermission();

if (isset($_GET['id'])) {
    $job_id = intval($_GET['id']);
    $conn->query("DELETE FROM jobs WHERE id = '$job_id'");
}

header("Location: manage_job.php");
exit();
?>
