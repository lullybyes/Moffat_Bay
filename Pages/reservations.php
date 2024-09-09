<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moffat Bay Lodge - Room Reservation</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Lora:wght@700&display=swap" rel="stylesheet">

    <?php

    // Enable error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    function reserveRoom() {
        session_start();
        include 'db_connect.php';

        // Get the form data
        $customer_id = $_POST['customer_id'];
        $room_id = $_POST['room_id'];
        $check_in_date = $_POST['check_in_date'];
        $check_out_date = $_POST['check_out_date'];
        $num_guests = $_POST['num_guests'];

        // Prepare the SQL statement to insert reservation data
        $stmt = $conn->prepare("INSERT INTO Reservation (customer_id, room_id, check_in_date, check_out_date, num_guests, reservation_status) VALUES (?, ?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("iissi", $customer_id, $room_id, $check_in_date, $check_out_date, $num_guests);

        // Execute and check if the reservation was successful
        if ($stmt->execute()) {
            echo "Reservation made successfully!";
        } else {
            echo "Error: Could not make the reservation.";
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    }

    if (isset($_POST['reserve-submit'])) {
        echo reserveRoom();
    }
    ?>
</head>
<body>
<header>
        <div class="logo">
            <h1>Moffat Bay Lodge</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="attractions.html">Attractions</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="reservations.php">Reservations</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <h2>Room Reservation</h2>

    <div class="contact-form-wrapper">
        <form class="contact-form" method="post">
            <div class="form-group">
                <label for="customer_id">Customer ID:</label><br>
                <input type="text" id="customer_id" name="customer_id" required><br>
            </div>
            <div class="form-group">
                <label for="room_id">Room ID:</label><br>
                <input type="text" id="room_id" name="room_id" required><br>
            </div>
            <div class="form-group">
                <label for="check_in_date">Check-in Date:</label><br>
                <input type="date" id="check_in_date" name="check_in_date" required><br>
            </div>
            <div class="form-group">
                <label for="check_out_date">Check-out Date:</label><br>
                <input type="date" id="check_out_date" name="check_out_date" required><br>
            </div>
            <div class="form-group">
                <label for="num_guests">Number of Guests:</label><br>
                <input type="number" id="num_guests" name="num_guests" min="1" required><br>
            </div>
            <div class="form-group" style="text-align: center;">
                <input type="submit" name="reserve-submit" class="contact-submit" value="Complete Reservation" style="width: 80%;">
            </div>
        </form>
    </div>
</body>
</html>
