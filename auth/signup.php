<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<div class="auth-container">
    <h2>Create Student Account</h2>
    <form action="process_signup.php" method="POST">
        <div class="form-group"><label>Full Name</label><input type="text" name="name" required></div>
        <div class="form-group"><label>UTeM Student/Staff Email</label><input type="email" name="email" required></div>
        <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
        <div class="form-group"><label>Matric / Staff ID</label><input type="text" name="matric_id" required></div>
        <div class="form-group">
            <label>Gender</label>
            <select name="gender" required><option value="Male">Male</option><option value="Female">Female</option></select>
        </div>
        <div class="form-group"><label>Phone Number</label><input type="text" name="phone" required></div>
        <div class="form-group">
            <label>Default Workspace Role</label>
            <select name="role"><option value="Passenger">Passenger</option><option value="Driver">Driver</option></select>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Register</button>
    </form>
    <p style="text-align:center; margin-top:15px;">Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>