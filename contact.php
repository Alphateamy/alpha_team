<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is blank
$dbname = "alpha_team";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the data into the database
    $sql = "INSERT INTO message (full_name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $full_name, $email, $subject, $message);

        if ($stmt->execute()) {
            echo "Message sent successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
