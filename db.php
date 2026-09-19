<?php
// InfinityFree database connection
$servername = "sql106.infinityfree.com";   // Host from control panel
$username   = "if0_42888299";              // Your InfinityFree username
$password   = "ronaldkwemoi";              // Your actual DB password from control panel
$dbname     = "if0_42888299_flexai";       // Your InfinityFree database name

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
