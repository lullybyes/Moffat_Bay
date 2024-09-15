<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $feedback = $_POST['feedback'];

    if (!empty($name) && !empty($feedback)) {
        $stmt = $conn->prepare("INSERT INTO feedback (name, feedback) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $feedback);

        if ($stmt->execute()) {
            echo "Thank you for your feedback!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill in all fields.";
    }
}
