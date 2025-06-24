<?php
require '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $booking_id = (int) $_POST['booking_id'];
    $new_status = $_POST['status'];

    if (in_array($new_status, ['pending', 'approved', 'rejected'])) {
        $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $booking_id);

        if ($stmt->execute()) {
            header("Location: admin_pesanan.php?success=1");
        } else {
            header("Location: admin_pesanan.php?error=db");
        }
        $stmt->close();
    } else {
        header("Location: admin_pesanan.php?error=invalid");
    }
} else {
    header("Location: admin_pesanan.php");
}