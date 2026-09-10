<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include('db.php');

// Get user info
$username = $_SESSION['username'];
$sql = "SELECT id, capital, profit FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$userId = $row['id'];
$capital = $row['capital'];
$profit = $row['profit'];

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Filter setup
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$whereClause = "t.user_id = $userId";
if ($filter == 'deposit') {
    $whereClause .= " AND t.type='deposit'";
} elseif ($filter == 'withdraw') {
    $whereClause .= " AND t.type='withdraw'";
}

// Fetch transactions
$sql = "
  SELECT t.type, t.amount, t.created_at
  FROM transactions t
  WHERE $whereClause
  ORDER BY t.created_at DESC
  LIMIT $limit OFFSET $offset
";
$txQuery = mysqli_query($conn, $sql);

// Count total for pagination
$countSql = "
  SELECT COUNT(*) as total
  FROM transactions t
  WHERE $whereClause
";
$countQuery = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countQuery);
$totalTx = $countRow['total'];
$totalPages = ceil($totalTx / $limit);
?>
<!DOCTYPE html>
<html>
<head>
    <title>flex ai Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#121212; color:#f0f0f0; font-family:Arial; margin:0; padding-bottom:70px; }
        h1,h4 { color:#00d4ff; }
        .visa-card {
            background: linear-gradient(135deg, #00d4ff, #0066ff);
            color: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
            text-align: center;
            margin-bottom: 20px;
        }
        .card { background:#1f1f1f; color:#f0f0f0; }
        .progress { height:20px; }
        .progress-bar { background-color:#28a745; }
        .transactions { background:#1f1f1f; padding:20px; border-radius:10px; margin-top:20px; }
        .bottom-nav i { font-size:24px; }
    </style>
</head>
<body>
<div class="container-fluid mt-4">

    <!-- Welcome -->
    <div class="d-flex align-items-center mb-4">
        <img src="images/logo.png" alt="Company Logo" style="height:80px; margin-right:30px;">
        <h1 class="mb-0">Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    </div>

    <!-- VISA Card -->
    <div class="visa-card">
        <h2>VISA</h2>
        <p>Balance: $<?php echo $capital; ?></p>
        <p>********</p>
        <p>09/36</p>
    </div>

    <!-- Deposit & Withdraw Forms -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="transaction.php" method="post" class="card p-3">
                <input type="number" step="0.01" name="amount" class="form-control mb-2" placeholder="Enter deposit amount" required>
                <button type="submit" name="action" value="deposit" class="btn btn-success w-100"><i class="bi bi-arrow-down-circle"></i> Deposit</button>
            </form>
        </div>
        <div class="col-md-6">
            <form action="transaction.php" method="post" class="card p-3">
                <input type="number" step="0.01" name="amount" class="form-control mb-2" placeholder="Enter withdraw amount" required>
                <button type="submit" name="action" value="withdraw" class="btn btn-danger w-100"><i class="bi bi-arrow-up-circle"></i> Withdraw</button>
            </form>
        </div>
    </div>

    <!-- How it Works -->
    <div class="card p-4 mb-4">
        <p><b>How it Works:</b> Fund your account, flex ai engages in intelligent digital Bitcoin mining. Capital remains 100% safe and profits will always accrue. Withdraw your funds anytime.</p>
    </div>

    <!-- Capital & Profit -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Capital</h5>
                <p class="fs-4">$<?php echo $capital; ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Profit</h5>
                <p class="fs-4 text-success">+$<?php echo $profit; ?></p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo ($capital>0)?($profit/$capital*100):0; ?>%">
                        <?php echo ($capital>0)?round($profit/$capital*100)."%":"0%"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Transactions -->
    <div class="transactions">
        <h4>My Transactions</h4>
        <div class="btn-group mb-3">
            <a href="dashboard.php?filter=all" class="btn btn-outline-light btn-sm">All</a>
            <a href="dashboard.php?filter=deposit" class="btn btn-outline-success btn-sm">Deposits</a>
            <a href="dashboard.php?filter=withdraw" class="btn btn-outline-danger btn-sm">Withdrawals</a>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($tx = mysqli_fetch_assoc($txQuery)): ?>
                        <tr>
                            <td><?php echo ucfirst($tx['type']); ?></td>
                            <td>$<?php echo $tx['amount']; ?></td>
                            <td><?php echo date("M d, Y H:i", strtotime($tx['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if($page<=1) echo 'disabled'; ?>">
                    <a class="page-link" href="?filter=<?php echo $filter; ?>&page=<?php echo $page-1; ?>">Previous</a>
                </li>
                <li class="page-item disabled"><span class="page-link">Page <?php echo $page; ?> of <?php echo $totalPages; ?></span></li>
                <li class="page-item <?php if($page>=$totalPages) echo 'disabled'; ?>">
                    <a class="page-link" href="?filter=<?php echo $filter; ?>&page=<?php echo $page+1; ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Add Funds -->
    <div class="transactions mt-4">
        <h4>Add Funds</h4>
        <p>Quickly top up your account balance.</p>
        <a href="deposit.php" class="btn btn-success"><i class="bi bi-wallet2"></i> Add Funds</a>
    </div>

    <!-- Logout Button -->
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
</div>

<!-- Bottom Navigation -->
<nav class="navbar fixed-bottom navbar-dark bg-dark">
  <div class="container-fluid justify-content-around">
    <a class="nav-link text-center" href="dashboard.php"><i class="bi bi-house"></i><br>Home</a>
    <a class="nav-link text-center" href="activity.php"><i class="bi bi-bar-chart"></i><br>Activities</a>
    <a class="nav-link text-center" href="support.php"><i class="bi bi-chat-dots"></i><br>Support</a>
    <a class="nav-link text-center" href="edit_profile.php"><i class="bi bi-person"></i><br>Profile</a>
  </div>
</nav>
