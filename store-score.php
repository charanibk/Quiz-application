<?php
session_start();
$conn = new mysqli("localhost", "root", "", "quiz_platform");
$user_id = $_SESSION['user_id'];
$score = $_POST['score'];
$title = $_POST['quiz_title'];
$conn->query("INSERT INTO scores (user_id, quiz_title, score) VALUES ($user_id, '$title', $score)");
?>
