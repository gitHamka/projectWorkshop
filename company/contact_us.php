<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<div class="auth-container">
    <h2>Contact Us / Feedback </h2>
    <form action="process_contact.php" method="POST">
            <div class="form-group"><label>Your Name</label><input type="text" name="name" placeholder="Muhammad Naeem Bin Mohd Razali" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" placeholder="d032410412@student.utem.edu.my" required></div>
        <div class="form-group"><label>Send Your Feedback</label><textarea name="message" class="form-group" style="width:100%; height:100px;" placeholder="GOOD!!!" required></textarea></div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Submit</button>
    </form>
</div>
</body>
</html>