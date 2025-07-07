<?php
session_start();
$conn = new mysqli("localhost", "root", "", "quiz_platform");

$username = $_POST['username'];
$password = $_POST['password'];

$result = $conn->query("SELECT * FROM users WHERE username='$username'");
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] === 'admin') {
        header("Location: ../admin/admin-dashboard.php");
    } else {
        header("Location: ../user/user-dashboard.php");
    }
} else {
    echo "Invalid username or password.";
}
?>



