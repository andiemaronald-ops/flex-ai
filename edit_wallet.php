<?php
session_start();
include('db.php');
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
$username = $_SESSION['username'];

// Fetch current wallet address from DB
$sql = "SELECT wallet_address FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$wallet = $row['wallet_address'] ?? "";

// Check if saved flag is set
$saved = isset($_GET['saved']) ? true : false;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crypto Wallet Address - flex ai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#121212; color:#f0f0f0; font-family:Arial; padding-bottom:70px; }
        .header { text-align:center; margin-bottom:30px; }
        .header img { height:80px; }
        .header h2 { margin-top:10px; color:#00d4ff; }
        .content { background:#1f1f1f; padding:20px; border-radius:10px; margin-bottom:20px; text-align:center; }
        h3 { color:#00d4ff; margin-bottom:20px; }
        .info-box { background:#2a2a2a; padding:15px; border-radius:8px; margin-bottom:15px; text-align:left; }
        .info-box b { color:#00d4ff; }
        .form-label { color:#f0f0f0; }
        .btn-green { background:#28a745; color:#fff; font-weight:bold; border:none; width:100%; }
        .alert-success { background:#28a745; color:#fff; border:none; border-radius:5px; padding:10px; margin-bottom:15px; }
        .copy-btn { background:#00d4ff; border:none; color:#000; padding:8px 12px; border-radius:5px; margin-left:5px; }
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

    <!-- Wallet Settings -->
    <div class="content">
        <h3>Crypto Wallet Address</h3>

        <?php if($saved): ?>
            <div class="alert-success">✅ Wallet address saved successfully!</div>
        <?php endif; ?>

        <div class="info-box">
            <b>Coin:</b> USDT
        </div>
        <div class="info-box">
            <b>Network:</b> TRX (TRC20)
        </div>

        <form method="POST" action="save_wallet.php">
            <div class="mb-3 text-start">
                <label for="wallet" class="form-label">Your Address</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="wallet" name="wallet" value="<?php echo $wallet; ?>" required>
                    <button type="button" class="copy-btn" onclick="copyWallet()"><i class="bi bi-clipboard"></i> Copy</button>
                </div>
            </div>
            <button type="submit" class="btn btn-green">Save Address</button>
        </form>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
        <a href="activity.php"><i class="bi bi-bar-chart"></i> Activities</a>
        <a href="support.php"><i class="bi bi-chat-dots"></i> Support</a>
        <a href="edit_profile.php"><i class="bi bi-person"></i> Profile</a>
    </nav>

<script>
function copyWallet() {
    var copyText = document.getElementById("wallet");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    alert("Wallet address copied: " + copyText.value);
}
</script>

</body>
</html>
