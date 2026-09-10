<?php
session_start();
include('db.php');
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
$username = $_SESSION['username'];

// Fetch referral stats
$statsQuery = mysqli_query($conn, "SELECT SUM(earned) as totalEarned, COUNT(*) as totalReferrals FROM referrals WHERE user='$username'");
$stats = mysqli_fetch_assoc($statsQuery);

$totalEarned = $stats['totalEarned'] ?? 0.00;
$totalReferrals = $stats['totalReferrals'] ?? 0;

// Get referral code (generate if not exists)
$codeQuery = mysqli_query($conn, "SELECT referral_code FROM referrals WHERE user='$username' LIMIT 1");
if ($row = mysqli_fetch_assoc($codeQuery)) {
    $referralCode = $row['referral_code'];
} else {
    // Generate a new code for this user
    $referralCode = rand(1000,9999);
    mysqli_query($conn, "INSERT INTO referrals (user, referral_code) VALUES ('$username','$referralCode')");
}
$referralLink = "https://flex ai.com/register?code=" . $referralCode;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Refer & Earn - flex ai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#121212; color:#f0f0f0; font-family:Arial; padding-bottom:70px; }
        .header { text-align:center; margin-bottom:30px; }
        .header img { height:80px; }
        .header h2 { margin-top:10px; color:#00d4ff; }
        .content { background:#1f1f1f; padding:20px; border-radius:10px; margin-bottom:20px; }
        .stats-box { display:flex; justify-content:space-around; margin-bottom:20px; }
        .stat { background:#1f1f1f; padding:15px; border-radius:10px; text-align:center; flex:1; margin:0 10px; }
        .stat h5 { color:#00d4ff; }
        .stat p { font-size:1.2rem; font-weight:bold; }
        .ref-link { background:#1f1f1f; padding:15px; border-radius:10px; text-align:center; }
        .ref-link input { background:#333; color:#fff; border:none; width:80%; padding:8px; border-radius:5px; }
        .ref-link button { background:#00d4ff; border:none; color:#000; padding:8px 12px; border-radius:5px; margin-left:5px; }
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

    <!-- Refer & Earn -->
    <div class="content text-center">
        <i class="bi bi-gift" style="font-size:40px; color:#00d4ff;"></i>
        <h3>Earn 20% Lifetime Commission</h3>
        <p>Get paid every time your friends deposit.</p>
    </div>

    <!-- Stats -->
    <div class="stats-box">
        <div class="stat">
            <h5>Total Earned</h5>
            <p>$<?php echo number_format($totalEarned, 2); ?></p>
        </div>
        <div class="stat">
            <h5>Referrals</h5>
            <p><?php echo $totalReferrals; ?></p>
        </div>
    </div>

    <!-- Referral Link -->
    <div class="ref-link">
        <h5>Your Referral Link</h5>
        <div class="d-flex justify-content-center">
            <input type="text" id="refLink" value="<?php echo $referralLink; ?>" readonly>
            <button onclick="copyLink()"><i class="bi bi-clipboard"></i> Copy</button>
        </div>
    </div>

    <!-- How it Works -->
    <div class="content">
        <h4>How it Works</h4>
        <ul>
            <li><b>Share your link:</b> Send your unique referral link to friends or community.</li>
            <li><b>Friend deposits:</b> They get a 100% welcome bonus on each deposit.</li>
            <li><b>You get 20%:</b> Receive 20% of their deposit instantly in your wallet.</li>
        </ul>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
        <a href="activity.php"><i class="bi bi-bar-chart"></i> Activities</a>
        <a href="support.php"><i class="bi bi-chat-dots"></i> Support</a>
        <a href="edit_profile.php"><i class="bi bi-person"></i> Profile</a>
    </nav>

<script>
function copyLink() {
    var copyText = document.getElementById("refLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999); 
    document.execCommand("copy");
    alert("Referral link copied: " + copyText.value);
}
</script>

</body>
</html>
