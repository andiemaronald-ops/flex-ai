<?php
session_start();
include('db.php');
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
$username = $_SESSION['username'];

$wallet = mysqli_real_escape_string($conn, $_POST['wallet']);
mysqli_query($conn, "UPDATE users SET wallet_address='$wallet' WHERE username='$username'");

header("Location: edit_wallet.php?saved=1");
exit();
?>
