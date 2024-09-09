<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moffat Bay Lodge - User Registration</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Lora:wght@700&display=swap" rel="stylesheet">
    <?php
    function registerUser() {
        include 'db_connect.php';

        $pass = $_POST['password'];
        $confpass = $_POST['confpassword'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        if ($pass != $confpass) {
            throw new Exception("Passwords do NOT match!");
        } else {
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO Customer (first_name, last_name, login_email, login_password, phone_number) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fname, $lname, $email, $pass, $phone);

            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                throw new Exception("An Error Occurred During Registration...");
            }

            $stmt->close();
            $conn->close();
        }
    }

    if (isset($_POST['register-submit'])) {
        echo registerUser();
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

    <h2>Register With Us</h2>

    <div class="contact-form-wrapper">
        <form class="contact-form" method="post">
            <div class="form-group">
                <div class="form-group" style="width: 49%; float: left;">
                    <label for="fname">First Name:</label><br>
                    <input type="text" id="fname" name="fname"><br>    
                </div>
                <div class="form-group" style="width: 49%; float: right;">
                    <label for="lname">Last Name:</label><br>
                    <input type="text" id="lname" name="lname" style="float: right;"><br>    
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label><br>
                <input type="text" id="email" name="email"><br>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label><br>
                <input type="text" id="phone" name="phone"><br>    
            </div>
            <div class="form-group">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password"><br>    
            </div>
            <div class="form-group">
                <label for="confpassword">Confirm Password:</label><br>
                <input type="password" id="confpassword" name="confpassword"><br>    
            </div>
            <div class="form-group" style="text-align: center;">
                <input type="submit" name="register-submit"class="contact-submit" value="Complete Registration" style="width: 80%;">
            </div>
        </form>
    </div>











</body>
</html>