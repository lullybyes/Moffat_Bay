<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moffat Bay Lodge - Login</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Lora:wght@700&display=swap" rel="stylesheet">
    <?php
    function loginUser() {
        session_start();
        include 'db_connect.php';
        // Prepare and bind the SQL statement 
        $stmt = $conn->prepare("SELECT customer_id, login_password FROM Customer WHERE login_email = ?"); $stmt->bind_param("s", $username); 

        // Get the form data 
        $username = $_POST['email']; $password = $_POST['password']; 

        // Execute the SQL statement 
        $stmt->execute(); $stmt->store_result(); 

        // Check if the user exists 
        if ($stmt->num_rows > 0) { 

        // Bind the result to variables 
        $stmt->bind_result($id, $hashed_password); 

        // Fetch the result 
        $stmt->fetch(); 

        // Verify the password 
        if (password_verify($password, $hashed_password)) { 

        // Set the session variables 
        $_SESSION['loggedin'] = true; $_SESSION['id'] = $id; $_SESSION['username'] = $username; 

        // Redirect to the user's dashboard 
        echo "Logged in Successfully!";
    } 
        
        else { echo "Incorrect password!"; } 
    } 
        
        else { echo "User not found!"; } 

        // Close the connection 
        $stmt->close(); $conn->close(); }

    if (isset($_POST['login-submit'])) {
        echo loginUser();
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

    <h2>Login to Moffatt Bay</h2>

    <div class="contact-form-wrapper">
        <form class="contact-form" method="post">
            <div class="form-group">
                <label for="email">Email Address:</label><br>
                <input type="text" id="email" name="email"><br>
            </div>
            <div class="form-group">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password"><br>    
            </div>
            <div class="form-group" style="text-align: center;">
                <input type="submit" name="login-submit"class="contact-submit" value="Login" style="width: 80%;">
            </div>
        </form>
    </div>
</body>
</html>