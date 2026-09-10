<?php
session_start();
include('db.php');
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
$username = $_SESSION['username'];

// Get the user's ID from the users table
$result = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
$row = mysqli_fetch_assoc($result);
$user_id = $row['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete user transactions using user_id
    mysqli_query($conn, "DELETE FROM transactions WHERE user_id='$user_id'");
    
    // Delete user account using username
    mysqli_query($conn, "DELETE FROM users WHERE username='$username'");
    
    session_destroy();
    header("Location: goodbye.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Account - flex ai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#121212; color:#f0f0f0; font-family:Arial; padding-bottom:70px; }
        .header { text-align:center; margin-bottom:30px; }
        .header img { height:80px; }
        .header h2 { margin-top:10px; color:#00d4ff; }
        .content { background:#1f1f1f; padding:20px; border-radius:10px; text-align:center; }
        h3 { color:#dc3545; margin-bottom:20px; }
        .warning-icon { font-size:60px; color:#dc3545; margin-bottom:15px; }
        .alert-danger { background:#dc3545; color:#fff; border:none; border-radius:5px; padding:15px; margin-top:20px; font-weight:bold; }
        .btn-red { background:#dc3545; color:#fff; font-weight:bold; border:none; width:100%; margin-top:20px; }
        .bottom-nav { position:fixed; bottom:0; width:100%; display:flex; justify-content:space-around; background:#1f1f1f; padding:10px; border-top:1px solid #333; }
        .bottom-nav a { text-decoration:none; color:#f0f0f0; text-align:center; }
        .bottom-nav i { display:block; font-size:20px; margin-bottom:3px; }
    </style>
</head>
<body class="container mt-4">

    <!-- Logo + Welcome -->
    <div class="header">
        <img src="images/logo.png" alt="flex ai Logo">
        <h2>Welcome, <?php echo $username; ?>!</h2>
    </div>

    <!-- Delete Account Warning -->
    <div class="content">
        <div class="warning-icon"><i class="bi bi-x-circle-fill"></i></div>
        <h3>Delete Account</h3>
        <p>If you delete this account, your transactions will be deleted as well!</p>

        <form method="POST">
            <button type="submit" class="btn btn-red">Delete Account</button>
        </form>

        <div class="alert-danger">
            ⚠️ This Action cannot be undone, proceed with caution!
        </div>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
        <a href="activity.php"><i class="bi bi-bar-chart"></i> Activities</a>
        <a href="support.php"><i class="bi bi-chat-dots"></i> Support</a>
        <a href="edit_profile.php"><i class="bi bi-person"></i> Profile</a>
    </nav>

</body>
</html>
