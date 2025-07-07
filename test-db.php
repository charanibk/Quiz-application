<?php
// Database credentials
$host = "localhost";
$user = "root";
$pass = "";
$db   = "quiz_platform";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
} else {
    echo "✅ Successfully connected to the database <strong>$db</strong>";
}
?>
