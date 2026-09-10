<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: admin_login.php");
    exit();
}
include('db.php');

// Get all users
$users = mysqli_query($conn, "SELECT * FROM users");

// Get all transactions
$transactions = mysqli_query($conn, "SELECT * FROM transactions ORDER BY created_at ASC");

// Quick stats
$total_users = mysqli_num_rows($users);
$total_capital = 0;
$total_profit = 0;
$pending_transactions = 0;

// Reset pointer for users loop
mysqli_data_seek($users, 0);
while ($u = mysqli_fetch_assoc($users)) {
    $total_capital += $u['capital'];
    $total_profit += $u['profit'];
}

// Reset pointer for transactions loop
$dates = [];
$capital_data = [];
$profit_data = [];

mysqli_data_seek($transactions, 0);
while ($t = mysqli_fetch_assoc($transactions)) {
    $dates[] = $t['created_at'];
    $capital_data[] = $t['amount']; // Example: treat amount as capital change
    $profit_data[] = ($t['action'] == 'deposit') ? $t['amount'] * 0.1 : 0; // Example profit logic
    if ($t['action'] == 'withdraw') {
        $pending_transactions++;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background: #f4f6f9; }
        .navbar-brand img { height: 50px; }
        .card-stats { text-align: center; color: #fff; }
        .card-stats h4 { margin: 0; font-size: 1.5rem; }
        .card-stats p { margin: 0; font-size: 0.9rem; }
        .card-stats i { font-size: 2rem; margin-bottom: 10px; display: block; }
        .bg-users { background: #2575fc; }
        .bg-capital { background: #28a745; }
        .bg-profit { background: #6a11cb; }
        .bg-pending { background: #ff6a00; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="flex ai Logo">
                flex ai Admin
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Transactions</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Welcome Admin, <?php echo $_SESSION['admin_name']; ?>!</h2>

        <!-- Quick Stats Cards -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card card-stats shadow-sm bg-users">
                    <div class="card-body">
                        <i class="bi bi-people-fill"></i>
                        <h4><?php echo $total_users; ?></h4>
                        <p>Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats shadow-sm bg-capital">
                    <div class="card-body">
                        <i class="bi bi-cash-stack"></i>
                        <h4>$<?php echo number_format($total_capital, 2); ?></h4>
                        <p>Total Capital</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats shadow-sm bg-profit">
                    <div class="card-body">
                        <i class="bi bi-graph-up-arrow"></i>
                        <h4>$<?php echo number_format($total_profit, 2); ?></h4>
                        <p>Total Profit</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats shadow-sm bg-pending">
                    <div class="card-body">
                        <i class="bi bi-hourglass-split"></i>
                        <h4><?php echo $pending_transactions; ?></h4>
                        <p>Pending Transactions</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Capital vs Profit Chart -->
        <div class="card mt-4 shadow-sm">
            <div class="card-header">Capital vs Profit Over Time</div>
            <div class="card-body">
                <canvas id="capitalProfitChart"></canvas>
            </div>
        </div>

        <!-- Users Table -->
        <!-- (your existing users table code here) -->

        <!-- Transactions Table -->
        <!-- (your existing transactions table code here) -->
    </div>

    <script>
        const ctx = document.getElementById('capitalProfitChart').getContext('2d');
        const capitalProfitChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dates); ?>,
                datasets: [
                    {
                        label: 'Capital',
                        data: <?php echo json_encode($capital_data); ?>,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40,167,69,0.2)',
                        fill: true
                    },
                    {
                        label: 'Profit',
                        data: <?php echo json_encode($profit_data); ?>,
                        borderColor: '#6a11cb',
                        backgroundColor: 'rgba(106,17,203,0.2)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Capital vs Profit Growth' }
                }
            }
        });
    </script>
</body>
</html>
