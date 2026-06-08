<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<!-- navbar -->
<header>
    <div class="logo-container">
        <img src="../assets/images/logo.png" alt="GreenRide Campus Logo">
        GREENRIDE CAMPUS
    </div>
    <nav>
        <a href="../auth/login.php" class="nav-login-btn">
            <span class="nav-user-icon">👤</span> Login
        </a>
    </nav>
</header>

    <!-- tagline + login -->
<div class="auth-hero">

    <!-- tagline -->
    <div class="auth-hero-text">
        <h1>
            <span class="text-green">Go</span><span class="text-white"> together,</span><br>
            <span class="text-green">Save</span><span class="text-white"> forever</span>
        </h1>
        <a href="../index.php" class="btn-homepage">HOMEPAGE ➔</a>
    </div>

    <!-- login -->
    <div class="auth-wrapper">
        <div class="auth-container">
            <a href="../index.php" class="auth-close">×</a>
            <h2>Login to your account</h2>

            <form action="process_login.php" method="POST">
                <div class="form-group">
                    <label>Matric / Staff ID</label>
                    <input type="text" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>

            <p class="no-account">Don't have an account?</p>
            <a href="signup.php" class="btn-signup-link">Sign up here</a>
        </div>
    </div>

</div>

</body>
</html>