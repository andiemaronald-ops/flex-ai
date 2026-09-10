<?php
session_start();
include('db.php');
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
$username = $_SESSION['username'];

$push = isset($_POST['push']) ? 1 : 0;
$email = isset($_POST['email']) ? 1 : 0;
$location = isset($_POST['location']) ? 1 : 0;

mysqli_query($conn, "UPDATE notification_settings 
    SET push_notifications='$push', email_notifications='$email', location_services='$location' 
    WHERE user='$username'");

header("Location: notifications.php?saved=1");
exit();
?>
