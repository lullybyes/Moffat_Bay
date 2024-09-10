<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Summary</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .home-link {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <h1>Moffat Bay Lodge - Reservation Summary</h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
        </ul>
    </nav>
</header>

<?php
if (isset($_GET['reservation_id'])) {
    include 'db_connect.php';

    $reservation_id = intval($_GET['reservation_id']);

    // Fetch reservation details
    $stmt = $conn->prepare("SELECT r.reservation_id, c.first_name, c.last_name, rm.room_type, r.check_in_date, r.check_out_date, r.num_guests, p.amount_paid
                            FROM Reservation r
                            JOIN Customer c ON r.customer_id = c.customer_id
                            JOIN Room rm ON r.room_id = rm.room_id
                            JOIN Payment p ON r.reservation_id = p.reservation_id
                            WHERE r.reservation_id = ?");
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo "<div style='margin-left: 50px;'>";
        echo "<p><strong>Reservation ID:</strong> " . $row['reservation_id'] . "</p>";
        echo "<p><strong>Customer Name:</strong> " . $row['first_name'] . " " . $row['last_name'] . "</p>";
        echo "<p><strong>Room Type:</strong> " . $row['room_type'] . "</p>";
        echo "<p><strong>Check-In Date:</strong> " . $row['check_in_date'] . "</p>";
        echo "<p><strong>Check-Out Date:</strong> " . $row['check_out_date'] . "</p>";
        echo "<p><strong>Number of Guests:</strong> " . $row['num_guests'] . "</p>";
        echo "<p><strong>Total Payment:</strong> $" . number_format($row['amount_paid'], 2) . "</p>";
        echo "</div>";
        
        // Simulate the email confirmation being sent
        echo "<p style='margin-left: 50px; color: green;'><strong>A confirmation has been sent to your e-mail.</strong></p>";
    } else {
        echo "<p style='color: red;'>Reservation not found.</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p style='color: red;'>No reservation found.</p>";
}
?>

</body>
</html>
