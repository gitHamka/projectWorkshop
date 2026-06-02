<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login-php</title>
    <link rel="stylesheet" href="projectWorkshop/assets/css/style.css">
</head>
<body>
    <header>
        <div id="logo">
            <a href="../index.php"><label>GREENRIDE CAMPUS</label></a>
        </div>
    </header>

    <main>
        <section>
            <label>Go Together, Save Forever</label>
        </section>

        <section>
            <div>
                <a href="../index.php">
                    <button>close</button>
                </a>
            </div>

            <div>
                <h2>CREATE YOUR ACCOUNT</h2>
            </div>

            <form class="login-form" action="process_signup.php" method="POST">
                <input type="text" name="fullname" placeholder="Full Name">
                <input type="text" name="id" placeholder="Matric / Staff ID">
                <input type="email" name="email" placeholder="Email">
                <input type="text" name="password" placeholder="Password">
                <button type="submit" >Sign Up</button>

                <label>Already have an account? <a href="login.php">Log in</a></label>
            </form>
        </section>
    </main>

     <footer>
        <table border="1">
            <tr>
                <td>GREENRIDE CAMPUS</td>
                <td>Company</td>
                <td>Explore</td>
                <td>Safety</td>
                <td>Support</td>
            </tr>

            <tr>
                <td>UTeM Carpooling Hub</td>
                <td><a href="company/about_us.php">About Us</a></td>
                <td><a href="trip/explore_trips.php">Find a Ride</a></td>
                <td><a href="safety/safetyPassenger.php">For Passengers</a></td>
                <td><a href="company/contact_us.php">Contact Us</a></td>
            </tr>

            <tr>
                <td>Fakulti Teknologi Maklumat dan Komunikasi</td>
                <td></td>
                <td>Post a Ride</td>
                <td><a href="safety/safetyDriver.php">For Drivers</a></td>
                <td><a href="safety/gender_preference_guide.php">Gender Preference Guide</a></td>
            </tr>
        </table>
        <hr>
        <p><small>&copy;2026 GREENRIDE CAMPUS - the OGs</small></p>
    </footer>
</body>
</html>