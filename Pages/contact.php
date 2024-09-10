<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Moffat Bay Lodge</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .confirmation-message {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: green;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <h1>Moffat Bay Lodge - Contact Us</h1>
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

<h2>Contact Us</h2>

<div class="contact-form-wrapper">
    <form class="contact-form" method="post">
        <div class="form-group">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"><br>
        </div>
        <div class="form-group">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email"><br>
        </div>
        <div class="form-group">
            <label for="subject">Subject:</label><br>
            <input type="text" id="subject" name="subject"><br>
        </div>
        <div class="form-group">
            <label for="message">Message:</label><br>
            <textarea id="message" name="message" rows="5"></textarea><br>
        </div>
        <div class="form-group" style="text-align: center;">
            <input type="submit" name="submit" class="contact-submit" value="Send Message" style="width: 80%;">
        </div>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    // Simulate the message being sent
    echo "<div class='confirmation-message'><strong>Your message has been sent successfully!</strong></div>";
}
?>

</body>
</html>
