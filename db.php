<?php
// Simple MySQLi connection (beginner-friendly)
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$servername = "127.0.0.1";   // or "localhost"
$username   = "root";        // XAMPP/WAMP default
$password   = "";            // set if you have one
$database   = "indian_health";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: set UTF-8 (handles Unicode/emoji safely)
$conn->set_charset("utf8mb4");
