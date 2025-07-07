<?php
$conn = new mysqli("localhost", "root", "", "quiz_platform");
$user = $_POST['username'];
$pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
$role = $_POST['role'];
$conn->query("INSERT INTO users (username, password, role) VALUES ('$user', '$pass', '$role')");
header("Location: ../login.html");
?>
