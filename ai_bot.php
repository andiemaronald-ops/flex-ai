<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

$userMessage = strtolower(trim($data['message']));
$reply = "";

session_start();
include('../db.php'); // connect to DB
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";

// Rule-based responses
if (strpos($userMessage, "deposit") !== false) {
    $reply = "To deposit funds, click the Deposit button on your dashboard and follow the instructions.";
} elseif (strpos($userMessage, "withdraw") !== false) {
    $reply = "Withdrawals are processed within 24 hours. Use the Withdraw button on your dashboard.";
} elseif (strpos($userMessage, "balance") !== false || strpos($userMessage, "capital") !== false) {
    $sql = "SELECT capital FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $balance = $row['capital'];
    $reply = "Your current balance is $" . $balance;
} elseif (strpos($userMessage, "profit") !== false) {
    $sql = "SELECT profit FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $profit = $row['profit'];
    $reply = "Your current profit is $" . $profit;
} elseif (strpos($userMessage, "help") !== false || strpos($userMessage, "support") !== false) {
    $reply = "Our support team is available 24/7. Please describe your issue and we’ll assist you.";
} else {
    $reply = "I'm here to help! Please ask about deposits, withdrawals, balances, or support.";
}

// Save chat log
$stmt = $conn->prepare("INSERT INTO chat_logs (username, user_message, bot_reply) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $userMessage, $reply);
$stmt->execute();

echo json_encode(["reply" => $reply]);
?>
