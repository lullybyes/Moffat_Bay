<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moffat Bay Lodge - Reservations</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Lora:wght@700&display=swap" rel="stylesheet">
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
                <li><a href="contact.php">Contact</a></li>
                <li><a href="reservations.php">Reservations</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <h2>Reserve a Room</h2>

    <?php
    session_start();
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        echo "<p style='color: red; text-align: center;'>You need to be logged in to make a reservation. Please <a href='login.php'>log in</a> first.</p>";
        exit;
    }

    function getAvailableRooms($conn) {
        $stmt = $conn->prepare("SELECT room_id, room_type FROM Room");
        $stmt->execute();
        $result = $stmt->get_result();
        $rooms = [];
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
        $stmt->close();
        return $rooms;
    }

    function calculatePrice($num_guests, $check_in_date, $check_out_date) {
        // Convert dates to DateTime objects
        $check_in = new DateTime($check_in_date);
        $check_out = new DateTime($check_out_date);
        $interval = $check_in->diff($check_out);
        $nights = $interval->days;

        // Determine price per night based on number of guests
        $price_per_night = ($num_guests <= 2) ? 115.00 : 150.00;

        return $nights * $price_per_night;
    }

    if (isset($_POST['reservation-submit'])) {
        include 'db_connect.php';

        $customer_id = $_SESSION['id'];
        $room_id = intval($_POST['room_id']);
        $check_in_date = $_POST['check_in_date'];
        $check_out_date = $_POST['check_out_date'];
        $num_guests = intval($_POST['num_guests']);
        $card_name = $_POST['card_name'];
        $card_number = $_POST['card_number'];
        $card_expiration = $_POST['card_expiration'];

        // Validate input
        if (empty($room_id) || empty($check_in_date) || empty($check_out_date) || empty($num_guests) || empty($card_name) || empty($card_number) || empty($card_expiration)) {
            echo "<p style='color: red;'>All fields are required.</p>";
        } else {
            // Check if the room is available
            $stmt = $conn->prepare("SELECT * FROM Reservation WHERE room_id = ? AND 
                                    (check_in_date BETWEEN ? AND ? OR check_out_date BETWEEN ? AND ?)");
            $stmt->bind_param("issss", $room_id, $check_in_date, $check_out_date, $check_in_date, $check_out_date);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<p style='color: red;'>The room is not available for the selected dates.</p>";
            } else {
                // Calculate the total price
                $total_price = calculatePrice($num_guests, $check_in_date, $check_out_date);

                // Insert reservation into the database
                $stmt = $conn->prepare("INSERT INTO Reservation (customer_id, room_id, check_in_date, check_out_date, num_guests, reservation_status) 
                                        VALUES (?, ?, ?, ?, ?, ?)");
                $reservation_status = "Confirmed";
                $stmt->bind_param("iissis", $customer_id, $room_id, $check_in_date, $check_out_date, $num_guests, $reservation_status);

                if ($stmt->execute()) {
                    $reservation_id = $stmt->insert_id;

                    // Insert payment info
                    $stmt = $conn->prepare("INSERT INTO Payment (reservation_id, amount_paid, payment_date, payment_status) 
                                            VALUES (?, ?, NOW(), ?)");
                    $payment_status = "Complete";
                    $stmt->bind_param("ids", $reservation_id, $total_price, $payment_status);

                    if ($stmt->execute()) {
                        // Redirect to ReservationSummary.php with reservation details
                        header("Location: ReservationSummary.php?reservation_id=" . $reservation_id);
                        exit;
                    } else {
                        echo "<p style='color: red;'>An error occurred while processing the payment.</p>";
                    }
                } else {
                    echo "<p style='color: red;'>An error occurred while creating the reservation.</p>";
                }
                $stmt->close();
            }
            $conn->close();
        }
    }
    ?>

    <div class="contact-form-wrapper">
        <form class="contact-form" method="post">
            <div class="form-group">
                <label for="room_id">Room Type:</label><br>
                <select id="room_id" name="room_id">
                    <option value="">Select a room</option>
                    <?php
                    include 'db_connect.php';
                    $rooms = getAvailableRooms($conn);
                    foreach ($rooms as $room) {
                        echo "<option value='" . $room['room_id'] . "'>" . $room['room_type'] . "</option>";
                    }
                    ?>
                </select><br>
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
                <input type="number" id="num_guests" name="num_guests" min="1" max="5"><br>
            </div>
            <!-- Payment Fields -->
            <div class="form-group">
                <label for="card_name">Full Name (on card):</label><br>
                <input type="text" id="card_name" name="card_name" required><br>
            </div>
            <div class="form-group">
                <label for="card_number">Card Number:</label><br>
                <input type="text" id="card_number" name="card_number" required><br>
            </div>
            <div class="form-group">
                <label for="card_expiration">Expiration Date (MM/YY):</label><br>
                <input type="text" id="card_expiration" name="card_expiration" required><br>
            </div>
            <div class="form-group" style="text-align: center;">
                <input type="submit" name="reservation-submit" class="contact-submit" value="Complete Reservation" style="width: 80%;">
            </div>
        </form>
    </div>

    <p style="text-align: center; margin-top: 20px;">If you already have a reservation, look up here:</p>
    <div style="text-align: center; margin-top: 5px;">
        <a href="ReservationLookup.php">
            <button class="contact-submit" style="width: 25%; font-size: 16px;">Look Up Reservation</button>
        </a>
    </div>
</body>
</html>
