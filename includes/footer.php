<?php
$base = str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 2);
?>
<footer>
    <div class="footer-content">
        <div class="footer-brand">
            <h3>GREENRIDE CAMPUS</h3>
            <p>UTeM Carpooling Hub<br>Fakulti Teknologi Maklumat dan Komunikasi</p>
        </div>
        <div class="footer-column">
            <h4>Company</h4>
            <ul><li><a href="<?php echo $base; ?>company/about_us.php">About Us</a></li></ul>
        </div>
        <div class="footer-column">
            <h4>Explore</h4>
            <ul>
                <li><a href="<?php echo $base; ?>trip/explore_trips.php">Find a ride</a></li>
                <li><a href="<?php echo $base; ?>trip/post_trip.php">Post a ride</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Safety</h4>
            <ul>
                <li><a href="<?php echo $base; ?>safety/safetyPassenger.php">For passengers</a></li>
                <li><a href="<?php echo $base; ?>safety/safetyDriver.php">For drivers</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Support</h4>
            <ul>
                <li><a href="<?php echo $base; ?>company/contact_us.php">Contact us</a></li>
                <li><a href="<?php echo $base; ?>safety/gender_preference_guide.php">Gender preference guide</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">©2026 GREENRIDE CAMPUS - the OGs</div>
</footer>
