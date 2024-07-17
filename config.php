<?php
session_start();

// Database connection
$conn = new mysqli("localhost:3307", "root", "", "library");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
