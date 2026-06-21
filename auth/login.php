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

<div class="auth-hero">
    <div class="auth-hero-text">
        <h1>
            <span class="text-green">Go</span><span class="text-white"> together,</span><br>
            <span class="text-green">Save</span><span class="text-white"> forever</span>
        </h1>
        <a href="../index.php" class="btn-homepage">HOMEPAGE ➔</a>
    </div>

    <div class="auth-wrapper">
        <div class="auth-container">
            <a href="../index.php" class="auth-close">×</a>
            <h2>Login to your account</h2>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials'): ?>
            <div class="alert-box alert-error"> Wrong Matric/Staff ID or password. Please try again.</div>
            <?php endif; ?>
            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'signup_success'): ?>
            <div class="alert-box alert-success"> Account created! You can now log in.</div>
            <?php endif; ?>

            <div id="form-alert" class="alert-box alert-error" style="display:none;"></div>

            <form action="process_login.php" method="POST" id="loginForm" novalidate>
                <div class="form-group">
                    <label>Matric / Staff ID</label>
                    <input type="text" name="matric_number" id="matric_number" placeholder="D032410412" required>
                    <div class="field-error" id="err-matric"> Please enter your Matric / Staff ID.</div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="password-input-wrapper">
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                        <button type="button" class="toggle-password" id="togglePassword">👁️</button>
                    </div>
                <div class="field-error" id="err-password"> Please enter your password.</div>
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>

            <p class="no-account">Don't have an account?</p>
            <a href="signup.php" class="btn-signup-link">Sign up here</a>
        </div>
    </div>
</div>

<script src="../assets/js/login.js"></script>
</body>
</html>