<?php
// db.php connection file
$host = "localhost";
$user = "root"; 
$pass = "";     
$db   = "flex ai";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm  = $_POST["confirm_password"];

    // Server-side validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "❌ Invalid email format!";
    } elseif (strlen($password) < 8 || 
              !preg_match("/[0-9]/", $password) || 
              !preg_match("/[A-Z]/", $password)) {
        $message = "❌ Password must be at least 8 characters, include a number and an uppercase letter.";
    } elseif ($password !== $confirm) {
        $message = "❌ Passwords do not match!";
    } else {
        // Check if email already exists
        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();

        if ($checkEmail->num_rows > 0) {
            $message = "❌ Email already registered. Please <a href='login.php'>login here</a>.";
            $checkEmail->close();
        } else {
            $checkEmail->close();

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashedPassword);

            if ($stmt->execute()) {
                $message = "✅ Registration successful. <a href='login.php'>Login here</a>";
            } else {
                $message = "❌ Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #121212;
            color: #f0f0f0;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px;
        }
        .register-container {
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
        .message {
            text-align: center;
            margin-bottom: 50px;
            font-weight: bold;
        }
        label {
            color: #ccc;
        }
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
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            height: 220px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Logo -->
        <div class="logo">
            <img src="images/logo.png" alt="Company Logo">
        </div>

        <h2>Create Account</h2>
        <?php if (!empty($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <small class="text-muted">Must be at least 8 characters, include a number and an uppercase letter.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <div class="text-center mt-3">
            <p>Already have an account? <a href="login.php" class="text-info">Login here</a></p>
        </div>
    </div>

    <!-- Client-side validation -->
    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
            const password = document.getElementById("password").value;
            const confirm  = document.getElementById("confirm_password").value;

            if (password.length < 8 || !/[0-9]/.test(password) || !/[A-Z]/.test(password)) {
                alert("Password must be at least 8 characters, include a number and an uppercase letter.");
                e.preventDefault();
            }
            if (password !== confirm) {
                alert("Passwords do not match!");
                e.preventDefault();
            }
        });
    </script>
</body>
</html>