<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<div class="auth-container">
    <h2>UTeM Carpooling Login</h2>
    <form action="process_login.php" method="POST">
        <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>
        <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Sign In</button>
    </form>
    <p style="text-align:center; margin-top:15px;">New member? <a href="signup.php">Register workspace</a></p>
</div>
</body>
</html>