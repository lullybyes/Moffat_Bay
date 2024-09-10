<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Look Up Reservation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .reservation-details {
            margin-left: 50px; /* Adjust this value for the desired indentation */
        }

        .form-container {
            text-align: center;
            margin-top: 20px;
        }

        .form-container form {
            display: inline-block;
            text-align: left;
        }

        .form-container input[type="submit"] {
            width: 80%;
            padding: 10px;
            margin-top: 10px;
            background-color: #3099B9; /* Set button color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #287a9b; /* Darker shade on hover */
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <h1>Moffat Bay Lodge - Look Up Reservation</h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
        </ul>
    </nav>
</header>

<h2 style="text-align: center;">Look Up Your Reservation</h2>

<div class="form-container">
    <form method="get" action="ReservationLookup.php">
        <div>
            <label for="reservation_id">Enter Reservation ID:</label><br>
            <input type="number" id="reservation_id" name="reservation_id" required>
        </div>
        <div>
            <input type="submit" value="Look Up Reservation">
        </div>
    </form>
</div>

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

        // Indented reservation details
        echo "<div class='reservation-details'>";
        echo "<p><strong>Reservation ID:</strong> " . $row['reservation_id'] . "</p>";
        echo "<p><strong>Customer Name:</strong> " . $row['first_name'] . " " . $row['last_name'] . "</p>";
        echo "<p><strong>Room Type:</strong> " . $row['room_type'] . "</p>";
        echo "<p><strong>Check-In Date:</strong> " . $row['check_in_date'] . "</p>";
        echo "<p><strong>Check-Out Date:</strong> " . $row['check_out_date'] . "</p>";
        echo "<p><strong>Number of Guests:</strong> " . $row['num_guests'] . "</p>";
        echo "<p><strong>Total Payment:</strong> $" . number_format($row['amount_paid'], 2) . "</p>";
        echo "</div>";
    } else {
        echo "<p style='color: red; text-align: center;'>Reservation not found.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
