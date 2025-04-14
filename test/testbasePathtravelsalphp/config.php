<?php
$servername = "localhost";
$username = "your_phpmyadmin_username";
$password = "your_phpmyadmin_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>