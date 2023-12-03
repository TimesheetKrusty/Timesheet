<?php
$hostname = 'localhost'; // Change if required
$username = 'root'; // Change to your MySQL username
$password = ''; // Change to your MySQL password
$database = 'krusty'; // Change to your desired database name

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
