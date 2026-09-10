<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Privacy Policy - flex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#121212; color:#f0f0f0; font-family:Arial; padding-bottom:70px; }
        .header { text-align:center; margin-bottom:30px; }
        .header img { height:80px; }
        .header h2 { margin-top:10px; color:#00d4ff; }
        .content { background:#1f1f1f; padding:20px; border-radius:10px; margin-bottom:20px; }
        h3, h4 { color:#00d4ff; }
        ul { margin-left:20px; }
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

    <!-- Privacy Policy Content -->
    <div class="content">
        <h3>Privacy Policy</h3>

        <h4>Introduction</h4>
        <p>Welcome to flex ai. We are committed to protecting your privacy and handling your personal information responsibly. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our website, trading platform, and related services.</p>

        <h4>Information We Collect</h4>
        <ul>
            <li><b>Personal Information:</b> Full name, email, phone, country, date of birth, ID documents.</li>
            <li><b>Account Information:</b> Username, encrypted password, profile preferences, subscription status.</li>
            <li><b>Trading Information:</b> Connected account details, broker info, trading history, performance stats, risk settings.</li>
            <li><b>Device Information:</b> IP address, browser type, device model, OS, app version, crash reports.</li>
            <li><b>Usage Information:</b> Pages visited, features used, login history, session duration, app interactions.</li>
        </ul>

        <h4>How We Use Your Information</h4>
        <ul>
            <li>Create and manage your account.</li>
            <li>Provide AI-powered trading insights and investment services.</li>
            <li>Process subscriptions and payments.</li>
            <li>Improve our AI models and platform.</li>
            <li>Provide customer support and detect fraud.</li>
            <li>Send important service notifications.</li>
            <li>Comply with legal and regulatory obligations.</li>
        </ul>

        <h4>AI Services</h4>
        <p>flex ai uses artificial intelligence to generate market analysis, trading insights, and investment recommendations. While our AI is designed to provide high-quality analysis, market conditions can change rapidly. Users remain responsible for all trading and investment decisions.</p>

        <h4>Data Sharing</h4>
        <p>We do not sell your personal information. We may share information only with:</p>
        <ul>
            <li>Payment service providers</li>
            <li>Cloud hosting providers</li>
            <li>Analytics providers</li>
            <li>Identity verification providers</li>
            <li>Customer support providers</li>
            <li>Regulatory or law enforcement authorities where legally required</li>
        </ul>

        <h4>Data Security</h4>
        <ul>
            <li>Encryption of sensitive information</li>
            <li>Secure HTTPS connections</li>
            <li>Firewalls and access controls</li>
            <li>Authentication mechanisms</li>
            <li>Continuous security monitoring</li>
        </ul>

        <h4>Cookies and Similar Technologies</h4>
        <p>We may use cookies to keep you signed in, remember preferences, improve performance, analyze usage, and enhance security. You may disable cookies in your browser, but some features may not function properly.</p>

        <h4>Your Rights</h4>
        <ul>
            <li>Access your personal information</li>
            <li>Correct inaccurate information</li>
            <li>Delete your account and personal data</li>
            <li>Restrict processing</li>
            <li>Object to certain processing activities</li>
        </ul>

        <h4>Account Security</h4>
        <ul>
            <li>Keep passwords confidential</li>
            <li>Protect login credentials</li>
            <li>Report unauthorized activity immediately</li>
            <li>Use strong passwords and enable security features</li>
        </ul>

        <h4>Changes to This Privacy Policy</h4>
        <p>We may update this Privacy Policy periodically. Updated versions will be posted within the application or website together with the revised effective date. Continued use of Swagmaster after changes become effective constitutes acceptance of the updated Privacy Policy.</p>

        <h4>Contact Us</h4>
        <p>If you have questions regarding this Privacy Policy or your personal information, please contact us through the official Swagmaster support channels.</p>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
        <a href="activity.php"><i class="bi bi-bar-chart"></i> Activities</a>
        <a href="support.php"><i class="bi bi-chat-dots"></i> Support</a>
        <a href="edit_profile.php"><i class="bi bi-person"></i> Profile</a>
    </nav>

</body>
</html>
