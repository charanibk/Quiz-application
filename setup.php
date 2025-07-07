<?php
$host="localhost"; $user="root"; $pass="";
$conn=new mysqli($host,$user,$pass);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$conn->query("CREATE DATABASE IF NOT EXISTS quiz_platform");
$conn->select_db("quiz_platform");

$sql = "
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(100), password VARCHAR(255), role ENUM('admin','user') DEFAULT 'user'
);
CREATE TABLE IF NOT EXISTS questions (
  id INT AUTO_INCREMENT PRIMARY KEY, quiz_title VARCHAR(100), question TEXT, option_a TEXT, option_b TEXT, option_c TEXT, option_d TEXT, correct_option CHAR(1)
);
CREATE TABLE IF NOT EXISTS scores (
  id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, quiz_title VARCHAR(100), score INT,
  FOREIGN KEY(user_id) REFERENCES users(id)
);";
if($conn->multi_query($sql)) echo "✅ Setup OK";
else echo "❌ Setup error: ".$conn->error;
?>
