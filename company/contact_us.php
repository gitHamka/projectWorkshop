<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>
<body>

     <header>
        <div id="logo">
            <a href="../index.php"><label>GREENRIDE CAMPUS</label></a>
        </div>
    </header>

    <main>
        <label><h1>CONTACT US</h1></label>

        <section class="form-container">
            <form action="process_contact.php" method="POST">
                <input type="text" name="contactName" placeholder="Your Name"> 
                <input type="email" name="contactEmail" placeholder="Your Email">
                <textarea name="contactMessage" rows="4" cols="50">  
                    Enter your message here..
                </textarea> 
                <button type="submit">Submit</button>
            <form>
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