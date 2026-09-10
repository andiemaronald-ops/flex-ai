<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
$username = $_SESSION['username'];

// Example: load current settings from DB (replace with your own table/logic)
include('db.php');
$sql = "SELECT push_notifications, email_notifications, location_services FROM notification_settings WHERE user='$username' LIMIT 1";
$result = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);

$push = $settings['push_notifications'] ?? 0;
$email = $settings['email_notifications'] ?? 1; // default ON
$location = $settings['location_services'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Notification Settings - flex ai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#121212; color:#f0f0f0; font-family:Arial; padding-bottom:70px; }
        .header { text-align:center; margin-bottom:30px; }
        .header img { height:80px; }
        .header h2 { margin-top:10px; color:#00d4ff; }
        .content { background:#1f1f1f; padding:20px; border-radius:10px; margin-bottom:20px; }
        h3 { color:#00d4ff; }
        .form-check-label { color:#f0f0f0; }
        .btn-teal { background:#00d4ff; color:#000; font-weight:bold; border:none; width:100%; }
        .bottom-nav { position:fixed; bottom:0; width:100%; display:flex; justify-content:space-around; background:#1f1f1f; padding:10px; border-top:1px solid #333; }
        .bottom-nav a { text-decoration:none; color:#f0f0f0; text-align:center; }
        .bottom-nav i { display:block; font-size:20px; margin-bottom:3px; }
    </style>
</head>
<body class="container mt-4">

    <!-- Logo + Welcome -->
    <div class="header">
        <img src="images/logo.png" alt="Flex ai Logo">
        <h2>Welcome, <?php echo $username; ?>!</h2>
    </div>

    <!-- Notification Settings -->
    <div class="content">
        <h3>Notifications</h3>
        <p>Choose what notifications you want to receive below and we will update the settings.</p>
        <form method="POST" action="save_notifications.php">
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="push" name="push" <?php if($push) echo "checked"; ?>>
                <label class="form-check-label" for="push">Push Notifications<br><small>Receive push notifications from our application on a semi regular basis.</small></label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="email" name="email" <?php if($email) echo "checked"; ?>>
                <label class="form-check-label" for="email">Email Notifications<br><small>Receive email notifications about new features.</small></label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="location" name="location" <?php if($location) echo "checked"; ?>>
                <label class="form-check-label" for="location">Location Services<br><small>Allow us to track your location to improve safety and spending insights.</small></label>
            </div>
            <button type="submit" class="btn btn-teal mt-3">Save Changes</button>
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
