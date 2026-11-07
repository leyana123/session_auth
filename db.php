

<?php

$conn = new mysqli("localhost", "root", "", "auth_demo");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// start sesh 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

