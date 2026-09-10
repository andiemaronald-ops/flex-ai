<?php
session_start();
include('db.php');
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT email FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$email = $row['email'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile - flex ai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style id="theme-style">
        body { background-color:#121212; color:#f0f0f0; font-family:Arial,sans-serif; padding-bottom:70px; }
        .header { text-align:center; margin-bottom:30px; }
        .header img { height:80px; }
        .header h2 { margin-top:10px; color:#00d4ff; }
        .list-group-item { background:#1f1f1f; color:#f0f0f0; display:flex; justify-content:space-between; align-items:center; }
        .list-group-item a { color:#00d4ff; text-decoration:none; flex-grow:1; }
        .list-group-item i { color:#888; }
        .bottom-nav { position:fixed; bottom:0; width:100%; display:flex; justify-content:space-around; background:#1f1f1f; padding:10px; border-top:1px solid #333; }
        .bottom-nav a { text-decoration:none; color:#f0f0f0; font-weight:500; text-align:center; }
        .bottom-nav i { display:block; font-size:20px; margin-bottom:3px; }
        .toggle-btn { display:block; margin:20px auto; padding:10px 20px; border:none; border-radius:5px; background:#00d4ff; color:#000; font-weight:bold; cursor:pointer; }
    </style>
</head>
<body class="container mt-4">

    <!-- Logo + Welcome -->
    <div class="header">
        <img src="images/logo.png" alt=" Logo">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <p><?php echo $email; ?></p>
    </div>

    <!-- Account Settings -->
    <h3>My Account</h3>
    <ul class="list-group">
<li class="list-group-item"><a href="edit_profile.php">Edit Profile</a><i class="bi bi-chevron-right"></i></li>
    <li class="list-group-item"><a href="edit_wallet.php">Edit Crypto Wallet Address</a><i class="bi bi-chevron-right"></i></li>
    <li class="list-group-item"><a href="change_password.php">Change Password</a><i class="bi bi-chevron-right"></i></li>
    <li class="list-group-item"><a href="notifications.php">Notification Settings</a><i class="bi bi-chevron-right"></i></li>
    <li class="list-group-item"><a href="how_it_work.php">How it Work</a><i class="bi bi-chevron-right"></i></li>
    <li class="list-group-item"><a href="refer.php">Refer & Earn</a><i class="bi bi-chevron-right"></i></li>
    <li class="list-group-item"><a href="privacy.php">Privacy Policy</a><i class="bi bi-chevron-right"></i></li>
    <li class="list-group-item"><a href="delete_account.php">Delete Account</a><i class="bi bi-chevron-right"></i>
    </ul>

    <!-- Theme Toggle -->
    <button class="toggle-btn" onclick="toggleTheme()">Light Mode</button>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
        <a href="activity.php"><i class="bi bi-bar-chart"></i> activities</a>
        <a href="support.php"><i class="bi bi-chat-dots"></i> Support</a>
        <a href="edit_profile.php"><i class="bi bi-person"></i> Profile</a>
    </nav>

<script>
function toggleTheme() {
    const style = document.getElementById("theme-style");
    const btn = document.querySelector(".toggle-btn");
    if (btn.innerText === "Light Mode") {
        style.innerHTML = `
            body { background-color:#f0f0f0; color:#121212; font-family:Arial,sans-serif; padding-bottom:70px; }
            .header h2 { color:#007bff; }
            .list-group-item { background:#fff; color:#121212; }
            .list-group-item a { color:#007bff; }
            .bottom-nav { background:#fff; border-top:1px solid #ccc; }
            .bottom-nav a { color:#121212; }
            .toggle-btn { background:#007bff; color:#fff; }
        `;
        btn.innerText = "Dark Mode";
    } else {
        style.innerHTML = `
            body { background-color:#121212; color:#f0f0f0; font-family:Arial,sans-serif; padding-bottom:70px; }
            .header h2 { color:#00d4ff; }
            .list-group-item { background:#1f1f1f; color:#f0f0f0; }
            .list-group-item a { color:#00d4ff; }
            .bottom-nav { background:#1f1f1f; border-top:1px solid #333; }
            .bottom-nav a { color:#f0f0f0; }
            .toggle-btn { background:#00d4ff; color:#000; }
        `;
        btn.innerText = "Light Mode";
    }
}
</script>

</body>
</html>
