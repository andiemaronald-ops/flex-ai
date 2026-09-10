<?php
include('db.php');
$message = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "SELECT id, reset_expiry FROM users WHERE reset_token=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (strtotime($row['reset_expiry']) < time()) {
            $message = "❌ Reset link expired.";
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST["password"];
            $confirm  = $_POST["confirm_password"];

            if ($password === $confirm && strlen($password) >= 8) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, reset_expiry=NULL WHERE id=?");
                $update->bind_param("si", $hashed, $row['id']);
                $update->execute();
                $message = "✅ Password updated. <a href='login.php'>Login here</a>";
            } else {
                $message = "❌ Passwords must match and be at least 8 characters.";
            }
        }
    } else {
        $message = "❌ Invalid reset link.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#121212; color:#f0f0f0; display:flex; justify-content:center; align-items:flex-start; padding:40px; }
        .container { background:#1f1f1f; padding:50px; border-radius:20px; width:100%; max-width:600px; }
        h2 { text-align:center; color:#00d4ff; margin-bottom:30px; }
        input { background:#2a2a2a; color:#fff; border:1px solid #444; }
        input:focus { background:#333; border-color:#00d4ff; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <?php if (!empty($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Password</button>
        </form>
    </div>
</body>
</html>
