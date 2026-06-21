 <?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if (isset($_GET['id'])) {
    $request_id = intval($_GET['id']);
    $user_id    = $_SESSION['user_id'];

    // verify booking current user punya
    $req = $conn->query("SELECT tr.*, t.trip_ID FROM triprequest tr
                         JOIN trip t ON tr.trip_ID = t.trip_ID
                         WHERE tr.request_ID='$request_id' AND tr.user_ID='$user_id'");
    $row = $req ? $req->fetch_assoc() : null;

    if ($row && $row['status'] != 'Cancelled') {
        $trip_id         = $row['trip_ID'];
        $seats_requested = $row['seats_requested'];
        $booking_id      = $row['booking_ID'];

        // cancel triprequest
        $conn->query("UPDATE triprequest SET status='Cancelled', response_time=NOW() WHERE request_ID='$request_id'");
        // cancel booking rec
        $conn->query("UPDATE booking SET status='Cancelled', cancelled_by='passenger', response_time=NOW() WHERE booking_ID='$booking_id'");
        // restore seats
        $conn->query("UPDATE trip SET seats_available = seats_available + $seats_requested WHERE trip_ID='$trip_id'");
    }

    header("Location: my_bookings.php?msg=cancelled");
    exit();
}

header("Location: my_bookings.php");
exit();
?>
