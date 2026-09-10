<?php
include('db.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $update = $conn->prepare("UPDATE users SET reset_token=?, reset_expiry=? WHERE email=?");
        $update->bind_param("sss", $token, $expiry, $email);
        $update->execute();

        // Normally you’d send an email here. For demo:
        $resetLink = "http://localhost/reset_password.php?token=$token";
        $message = "✅ Reset link generated: <a href='$resetLink'>Click here</a>";
    } else {
        $message = "❌ No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
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
        <h2>Forgot Password</h2>
        <?php if (!empty($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
        <div class="text-center mt-3">
            <a href="login.php" class="text-info">Back to Login</a>
        </div>
    </div>
</body>
</html>
