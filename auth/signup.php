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

<!-- tagline + signup -->
<div class="auth-hero">

<!-- tagline -->
    <div class="auth-hero-text">
        <h1>
            <span class="text-green">Go</span><span class="text-white"> together,</span><br>
            <span class="text-green">Save</span><span class="text-white"> forever</span>
        </h1>
        <a href="../index.php" class="btn-homepage">HOMEPAGE ➔</a>
    </div>

    <!-- signup -->
    <div class="auth-wrapper">
        <div class="auth-container">
            <a href="../index.php" class="auth-close">×</a>
            <h2>Create your account</h2>

            <form action="process_signup.php" method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Matric / Staff ID</label>
                    <input type="text" name="matric_id" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" required>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role">
                        <option value="Passenger">Passenger</option>
                        <option value="Driver">Driver</option>
                    </select>
                </div>
                <div class="form-checkbox">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                <button type="submit" class="btn-signup-submit">Sign up</button>
            </form>

            <p class="already-account">Already have an account? <a href="login.php">Log in</a></p>
        </div>
    </div>

</div>

</body>
</html>