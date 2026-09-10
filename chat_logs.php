<?php
session_start();
include('../db.php');

// Only allow admins
if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$result = mysqli_query($conn, "SELECT * FROM chat_logs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h1>Customer Chat Logs</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Message</th>
                <th>Reply</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['user_message']; ?></td>
                    <td><?php echo $row['bot_reply']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
