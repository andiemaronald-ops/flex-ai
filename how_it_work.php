<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>How it Works - flex ai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#121212; color:#f0f0f0; font-family:Arial; padding-bottom:90px; }
        .header { text-align:center; margin-bottom:30px; }
        .header img { height:120px; }
        .header h2 { margin-top:50px; color:#00d4ff; }
        .content { background:#1f1f1f; padding:40px; border-radius:40px; }
        .bottom-nav { position:fixed; bottom:0; width:100%; display:flex; justify-content:space-around; background:#1f1f1f; padding:10px; border-top:1px solid #333; }
        .bottom-nav a { text-decoration:none; color:#f0f0f0; text-align:center; }
        .bottom-nav i { display:block; font-size:20px; margin-bottom:3px; }
    </style>
</head>
<body class="container mt-4">
    <div class="header">
        <img src="images/logo.png" alt="Logo">
        <h2>Welcome, <?php echo $username; ?>!</h2>
    </div>
    <div class="content">
        <h3>How flex ai Works</h3>
        <p>flex ai automates trading and investment:</p>
        <ul>
            <li>Deposit funds into your account.</li>
            <li>AI analyzes markets and executes trades.</li>
            <li>Withdraw profits anytime.</li>
            <li>Track growth in your dashboard.</li>
        </ul>
    </div>
    <nav class="bottom-nav">
        <a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
        <a href="activity.php"><i class="bi bi-bar-chart"></i> Activities</a>
        <a href="support.php"><i class="bi bi-chat-dots"></i> Support</a>
        <a href="edit_profile.php"><i class="bi bi-person"></i> Profile</a>
    </nav>
</body>
</html>
