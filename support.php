<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Support - flex ai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #f0f0f0;
            font-family: Arial, sans-serif;
            padding-bottom: 70px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img { height: 80px; }
        .header h2 { margin-top: 10px; color: #00d4ff; }
        .chat-header { background:#1f1f1f; padding:15px; border-radius:8px; margin-bottom:20px; }
        .chat-header h3 { margin:0; color:#00d4ff; }
        .chat-header small { color:#8affc1; }
        .intro-text { background:#1f1f1f; padding:20px; border-radius:10px; margin-bottom:20px; }
        .intro-text h4 { color:#00d4ff; }
        #chatbox { background:#1f1f1f; border-radius:10px; padding:15px; height:250px; overflow-y:auto; margin-bottom:20px; }
        .input-group input { background:#333; color:#fff; border:none; }
        .input-group button { background:#00d4ff; border:none; color:#000; }
        .bottom-nav { position:fixed; bottom:0; width:100%; display:flex; justify-content:space-around; background:#1f1f1f; padding:10px; border-top:1px solid #333; }
        .bottom-nav a { text-decoration:none; color:#f0f0f0; font-weight:500; text-align:center; }
        .bottom-nav i { display:block; font-size:20px; margin-bottom:3px; }
    </style>
</head>
<body class="container mt-4">

    <div class="header">
        <img src="images/logo.png" alt="flex ai Logo">
        <h2>Welcome, <?php echo $username; ?>!</h2>
    </div>

    <div class="chat-header">
        <h3>flex ai <small>● Reonel Online</small></h3>
    </div>

    <div class="intro-text">
        <h4>Let AI Trade. You Stay in Control.</h4>
        <p>flex ai is an intelligent trading and investment partner designed to manage your trading account automatically.</p>
        <ul>
            <li><b>Fund Your Account:</b> Deposit your capital.</li>
            <li><b>Activate SwingMaster AI:</b> AI begins analysing and trading.</li>
            <li><b>Track Your Growth:</b> Monitor performance and profits.</li>
        </ul>
    </div>

    <div id="chatbox"></div>
    <div class="input-group mt-2">
        <input type="text" id="userInput" class="form-control" placeholder="Ask your question...">
        <button class="btn btn-primary" onclick="sendMessage()">Send</button>
    </div>

    <nav class="bottom-nav">
        <a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
        <a href="activity.php"><i class="bi bi-bar-chart"></i> Activities</a>
        <a href="support.php"><i class="bi bi-chat-dots"></i> Support</a>
        <a href="edit_profile.php"><i class="bi bi-person"></i> Profile</a>
    </nav>

<script>
function sendMessage() {
    let msg = document.getElementById("userInput").value;
    if (!msg) return;
    fetch("ai-bot/chat.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({message: msg})
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById("chatbox").innerHTML += "<p><b>You:</b> " + msg + "</p>";
        document.getElementById("chatbox").innerHTML += "<p><b>Reonel:</b> " + data.reply + "</p>";
        document.getElementById("userInput").value = "";
    });
}
</script>
</body>
</html>
