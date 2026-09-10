<?php
session_start();
include('db.php');

$message = "";
$type = ""; // success or error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $type = "success";
            $message = "✅ Login successful! Redirecting...";
            header("refresh:2;url=dashboard.php"); // redirect after 2 seconds
        } else {
            $type = "error";
            $message = "❌ Incorrect password.";
        }
    } else {
        $type = "error";
        $message = "❌ No account found with that email.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #121212;
            color: #f0f0f0;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px;
        }
        .login-container {
            background: #1f1f1f;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 1700px;
        }
        h2 {
            text-align: center;
            color: #00d4ff;
            margin-bottom: 30px;
        }
        .btn-primary {
            background: #00d4ff;
            border: none;
        }
        .btn-primary:hover {
            background: #0072ff;
        }
        label { color: #ccc; }
        input {
            background: #2a2a2a;
            color: #fff;
            border: 1px solid #444;
        }
        input:focus {
            background: #333;
            border-color: #00d4ff;
            color: #fff;
        }
        .logo { text-align: center; margin-bottom: 20px; }
        .logo img { height: 120px; }
        /* Toast positioning */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Logo -->
        <div class="logo">
            <img src="images/logo.png" alt="Company Logo">
        </div>

        <h2>Login</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Forgot Password + Register Links -->
        <div class="text-center mt-3">
            <p><a href="forgot_password.php" class="text-info">Forgot your password?</a></p>
            <p>Don't have an account? <a href="register.php" class="text-info">Register here</a></p>
        </div>
    </div>

    <!-- Toast Notification -->
    <?php if (!empty($message)): ?>
    <div class="toast-container">
        <div class="toast align-items-center text-bg-<?php echo ($type=="success")?"success":"danger"; ?> border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $message; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
