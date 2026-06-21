<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - GreenRide Campus</title>
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
            <h2>Create your account</h2>

            <div id="form-alert" class="alert-box alert-error" style="display:none;"></div>

            <form action="process_signup.php" method="POST" id="signupForm" novalidate>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Muhammad Naeem Bin Mohd Razali" required>
                    <div class="field-error" id="err-name"></div>
                </div>

                <div class="form-group">
                    <label>Matric / Staff ID</label>
                    <input type="text" name="matric_id" id="matric_id" placeholder="D032410412" required>
                    <div class="field-error" id="err-matric"></div>
                </div>

                <div class="form-group">
                    <label>UTeM Email</label>
                    <input type="email" name="email" id="email" placeholder="d032410412@student.utem.edu.my" required>
                    <div class="field-error" id="err-email"></div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="At least 6 characters" required>
                    <div class="password-strength" id="strength-bar"></div>
                    <div class="strength-label" id="strength-label" style="color:#999;"></div>
                    <div class="field-error" id="err-password"></div>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" id="phone" placeholder="0123456789" required>
                    <div class="field-error" id="err-phone"></div>
                </div>

                <div class="form-checkbox">
                    <input type="checkbox" name="terms" id="terms">
                    <label for="terms">Agree terms and conditions</label>
                </div>
                <div class="field-error" id="err-terms" style="margin-bottom:10px;"></div>

                <button type="submit" class="btn-signup-submit">Sign Up</button>
            </form>

            <p class="already-account">Already have an account? <a href="login.php">Log in</a></p>
        </div>
    </div>
</div>

<script src="../assets/js/signup.js"></script>
</body>
</html>