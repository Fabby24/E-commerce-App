<?php
$host = "localhost"; // Database host
$user = "root"; // Database username
$password = ""; // Database password
$dbname = ""; // Database name

// Create a new connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    // It's good practice to log errors and show a generic error message
    error_log("Connection failed: " . $conn->connect_error);
    die("Database connection failed. Please try again later.");
}

// Set the character set to UTF-8 to handle any special characters
$conn->set_charset("utf8mb4");
?>
