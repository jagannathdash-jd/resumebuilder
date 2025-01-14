<?php
session_start();
include '../include/db.php';
include '../include/function.php';

redirectIfNotLoggedIn();
checkAdminPermission();

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $conn->query("DELETE FROM users WHERE id = '$user_id'");
}

header("Location: manage_user.php");
exit();
?>
