<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moffat Bay Lodge - Reservations</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Lora:wght@700&display=swap" rel="stylesheet">
    <?php
    function reserveRoom() {
        include 'db_connect.php';

        // Fetch and sanitize form data
        $customer_id = intval($_POST['customer_id']);
        $room_id = intval($_POST['room_id']);
        $check_in_date = $_POST['check_in_date'];
        $check_out_date = $_POST['check_out_date'];
        $num_guests = intval($_POST['num_guests']);

        // Input validation
        if (empty($customer_id) || empty($room_id) || empty($check_in_date) || empty($check_out_date) || empty($num_guests)) {
            throw new Exception("All fields are required!");
        }

        // Check if room is available during the requested dates
        $stmt = $conn->prepare("SELECT * FROM Reservation WHERE room_id = ? AND 
                                (check_in_date BETWEEN ? AND ? OR check_out_date BETWEEN ? AND ?)");
        $stmt->bind_param("issss", $room_id, $check_in_date, $check_out_date, $check_in_date, $check_out_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            throw new Exception("The room is not available for the selected dates.");
        }

        // Insert reservation into the database
        $stmt = $conn->prepare("INSERT INTO Reservation (customer_id, room_id, check_in_date, check_out_date, num_guests, reservation_status) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $reservation_status = "Confirmed";
        $stmt->bind_param("iissis", $customer_id, $room_id, $check_in_date, $check_out_date, $num_guests, $reservation_status);

        if ($stmt->execute()) {
            echo "Reservation successfully created!";
        } else {
            throw new Exception("An error occurred while creating the reservation.");
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    if (isset($_POST['reservation-submit'])) {
        try {
            reserveRoom();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
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

    <h2>Reserve a Room</h2>

    <div class="contact-form-wrapper">
        <form class="contact-form" method="post">
            <div class="form-group">
                <label for="customer_id">Customer ID:</label><br>
                <input type="number" id="customer_id" name="customer_id"><br>
            </div>
            <div class="form-group">
                <label for="room_id">Room ID:</label><br>
                <input type="number" id="room_id" name="room_id"><br>
            </div>
            <div class="form-group">
                <label for="check_in_date">Check-In Date:</label><br>
                <input type="date" id="check_in_date" name="check_in_date"><br>
            </div>
            <div class="form-group">
                <label for="check_out_date">Check-Out Date:</label><br>
                <input type="date" id="check_out_date" name="check_out_date"><br>
            </div>
            <div class="form-group">
                <label for="num_guests">Number of Guests:</label><br>
                <input type="number" id="num_guests" name="num_guests"><br>
            </div>
            <div class="form-group" style="text-align: center;">
                <input type="submit" name="reservation-submit" class="contact-submit" value="Complete Reservation" style="width: 80%;">
            </div>
        </form>
    </div>
</body>
</html>
