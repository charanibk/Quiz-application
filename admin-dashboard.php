<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/styles.css">
  <style>
    .dashboard-buttons {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 20px;
    }
    .dashboard-buttons a {
      display: block;
      padding: 12px;
      background: linear-gradient(45deg, #ff6b6b, #f06595);
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: background 0.3s;
    }
    .dashboard-buttons a:hover {
      background: linear-gradient(45deg, #f06595, #ff6b6b);
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Welcome Admin, <?= htmlspecialchars($_SESSION['username']) ?></h2>

    <div class="dashboard-buttons">
      <a href="../add-questions.html">➕ Add New Question</a>
      <a href="admin-viewscore.php">📊 View All Scores</a>
      <a href="../php/logout.php">🚪 Logout</a>
    </div>
  </div>
</body>
</html>
