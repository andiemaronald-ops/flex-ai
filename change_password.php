<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
$username = $_SESSION['username'];

// Fetch user email from DB
include('db.php');
$sql = "SELECT email FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$email = $row['email'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Password - flex ai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#121212; color:#f0f0f0; font-family:Arial; padding-bottom:70px; }
        .header { text-align:center; margin-bottom:30px; }
        .header img { height:80px; }
        .header h2 { margin-top:10px; color:#00d4ff; }
        .content { background:#1f1f1f; padding:20px; border-radius:10px; margin-bottom:20px; }
        h3 { color:#00d4ff; }
        .form-label { color:#f0f0f0; }
        .btn-teal { background:#00d4ff; color:#000; font-weight:bold; border:none; width:100%; }
        .back { color:#00d4ff; text-decoration:none; display:inline-block; margin-bottom:15px; }
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

    <!-- Change Password Form -->
    <div class="content">
        <a href="profile.php" class="back"><i class="bi bi-arrow-left"></i> Back</a>
        <h3>Change Password</h3>
        <p>Enter the email associated with your account and we’ll send you a link to reset your password.</p>
        <form method="POST" action="send_reset.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <button type="submit" class="btn btn-teal">Send Reset Link</button>
        </form>
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
