<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['amount']) || !isset($_POST['action'])) {
    die("Invalid request.");
}

$username = $_SESSION['username'];
$amount   = (float)$_POST['amount']; 
$action   = $_POST['action'];

// Get current user info
$sql = "SELECT id, capital FROM users WHERE username=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$userId = $row['id'];
$currentCapital = $row['capital'];

// Deposit or Withdraw logic
if ($action == "deposit") {
    $newCapital = $currentCapital + $amount;
    $type = "deposit";
} elseif ($action == "withdraw") {
    if ($amount > $currentCapital) {
        die("Insufficient funds!");
    }
    $newCapital = $currentCapital - $amount;
    $type = "withdraw";
} else {
    die("Invalid action.");
}

// Update user capital
$updateSql = "UPDATE users SET capital=? WHERE id=?";
$updateStmt = mysqli_prepare($conn, $updateSql);
mysqli_stmt_bind_param($updateStmt, "di", $newCapital, $userId);
mysqli_stmt_execute($updateStmt);

// Log transaction
$logSql = "INSERT INTO transactions (user_id, type, amount, created_at) VALUES (?, ?, ?, NOW())";
$logStmt = mysqli_prepare($conn, $logSql);
mysqli_stmt_bind_param($logStmt, "isd", $userId, $type, $amount);
mysqli_stmt_execute($logStmt);

header("Location: dashboard.php");
exit();
?>
