<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit("Unauthorized access.");
}

// Database connection
$conn = new mysqli("localhost", "root", "", "quiz_platform");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch scores
$result = $conn->query("
    SELECT u.username, s.quiz_title, s.score
    FROM scores s
    JOIN users u ON s.user_id = u.id
    ORDER BY s.quiz_title, u.username
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - View All Scores</title>
  <link rel="stylesheet" href="../css/styles.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f4f8;
      margin: 0;
      padding: 40px;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ccc;
    }
    th {
      background-color: #007bff;
      color: white;
      padding: 12px;
    }
    td {
      padding: 10px;
      text-align: center;
    }
    a.btn-back {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      padding: 10px 18px;
      background-color: #6c757d;
      color: white;
      border-radius: 6px;
    }
    a.btn-back:hover {
      background-color: #5a6268;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>📊 All User Scores</h2>

    <?php if ($result->num_rows > 0): ?>
    <table>
      <tr>
        <th>Username</th>
        <th>Quiz Title</th>
        <th>Score</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['quiz_title']) ?></td>
        <td><?= $row['score'] ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
    <?php else: ?>
      <p>No scores found.</p>
    <?php endif; ?>

    <a href="admin-dashboard.php" class="btn-back">← Back to Dashboard</a>
  </div>
</body>
</html>
<?php
$conn->close();
?>









































