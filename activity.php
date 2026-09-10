<?php
session_start();
include('db.php');
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Example queries
$deposits = mysqli_query($conn, "SELECT SUM(amount) as total FROM transactions WHERE type='deposit'");
$payouts = mysqli_query($conn, "SELECT SUM(amount) as total FROM transactions WHERE type='withdraw'");
$recent = mysqli_query($conn, "SELECT * FROM transactions ORDER BY created_at DESC LIMIT 10");

$deposit_total = mysqli_fetch_assoc($deposits)['total'] ?? 0;
$payout_total = mysqli_fetch_assoc($payouts)['total'] ?? 0;

// Calculate payout percentage relative to deposits
$percentage = $deposit_total > 0 ? round(($payout_total / $deposit_total) * 100, 2) : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Activities - flex ai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212; /* dark background */
            color: #f0f0f0;
            font-family: Arial, sans-serif;
            padding-bottom: 70px; /* space for bottom nav */
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            height: 80px;
        }
        .header h2 {
            margin-top: 10px;
            color: #00d4ff;
        }
        .activity-box {
            background: #1f1f1f;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .activity-box h5 {
            margin-bottom: 10px;
            color: #f0f0f0;
        }
        .activity-box.deposit p {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745; /* green */
        }
        .activity-box.payout p {
            font-size: 1.5rem;
            font-weight: bold;
            color: #dc3545; /* red */
        }
        .progress {
            height: 12px;
            background-color: #333;
            border-radius: 6px;
        }
        .progress-bar {
            background-color: #dc3545;
        }
        table {
            background: #1f1f1f;
            border-radius: 10px;
            overflow: hidden;
        }
        table thead {
            background: #2a2a2a;
            color: #00d4ff;
        }
        table tbody tr td {
            color: #f0f0f0;
        }
        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            background: #1f1f1f;
            padding: 10px;
            border-top: 1px solid #333;
        }
        .bottom-nav a {
            text-decoration: none;
            color: #f0f0f0;
            font-weight: 500;
            text-align: center;
        }
        .bottom-nav i {
            display: block;
            font-size: 20px;
            margin-bottom: 3px;
        }
    </style>
</head>
<body class="container mt-4">

    <!-- Logo + Welcome -->
    <div class="header">
        <img src="images/logo.png" alt="flex ai Logo">
        <h2>Welcome, <?php echo $username; ?>!</h2>
    </div>

    <!-- Deposits & Payouts -->
    <h2>📊 All Users Activities</h2>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="activity-box deposit">
                <h5>Deposits</h5>
                <p>+$<?php echo number_format($deposit_total, 2); ?></p>
                <i class="bi bi-arrow-up-circle" style="color:#28a745; font-size:24px;"></i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="activity-box payout">
                <h5>Payouts</h5>
                <p>+$<?php echo number_format($payout_total, 2); ?></p>
                <div class="progress mt-2">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo min($percentage,100); ?>%">
                        <?php echo $percentage; ?>%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <h4>All Users Recent Transactions</h4>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($recent)) { ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo ucfirst($row['action']); ?></td>
                    <td>$<?php echo number_format($row['amount'], 2); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
        <a href="activities.php"><i class="bi bi-bar-chart"></i> Activities</a>
        <a href="support.php"><i class="bi bi-chat-dots"></i> Support</a>
        <a href="edit_profile.php"><i class="bi bi-person"></i> Profile</a>
    </nav>

</body>
</html>
