<?php 
$conn = new mysqli('localhost', 'root', '', 'eventdb');

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
