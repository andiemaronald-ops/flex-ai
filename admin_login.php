<?php
session_start();
include('db.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_name'] = $row['admin_name'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid admin credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ff6a00 0%, #ee0979 100%);
            font-family: Arial, sans-serif;
        }
        .login-container {
            max-width: 420px;
            width: 100%;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.25);
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            height: 80px;
        }
        h3 {
            color: #ee0979;
        }
        .btn-primary {
            background-color: #ff6a00;
            border: none;
        }
        .btn-primary:hover {
            background-color: #ee0979;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Logo -->
        <div class="logo">
            <img src="images/logo.png" alt="flex ai Logo">
        </div>

        <!-- Welcome Text -->
        <h3 class="text-center mb-3">Welcome Admin</h3>
        <p class="text-center text-muted">Login to access your dashboard</p>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <!-- Login Form -->
        <form action="admin_login.php" method="post">
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Extra Links -->
        <div class="text-center mt-3">
            <a href="#" class="text-muted">Forgot Password?</a><br>
            <a href="login.php" class="text-muted">Back to User Login</a>
        </div>
    </div>
</body>
</html>
