<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GreenRide Campus - UTeM Carpooling Hub</title> [cite: 132]
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <div style="font-size:24px; font-weight:bold;">GREENRIDE CAMPUS</div>
    <div>
        <a href="auth/login.php" class="btn btn-primary">Login</a>
        <a href="auth/signup.php" class="btn" style="background:#fff; color:#2e7d32;">Sign Up</a>
    </div>
</header>
<div class="container" style="text-align:center; padding-top:60px;">
    <h1>Ride Together. Save Forever.</h1>
    <p style="font-size:18px; max-width:700px; margin:20px auto; line-height:1.6;">
        [cite_start]Welcome to the official UTeM student carpooling platform[cite: 1, 14]. [cite_start]Connect safely with fellow campus commuters to reduce traffic emissions, bypass congestion, and split travel overheads cleanly[cite: 1, 15, 16].
    </p>
    <br>
    <a href="auth/signup.php" class="btn btn-primary" style="font-size:20px; padding:15px 40px;">Get Started Now</a>
</div>
[cite_start]<footer>@2026 GREENRIDE CAMPUS - the OGs [cite: 6, 84]</footer>
</body>
</html>