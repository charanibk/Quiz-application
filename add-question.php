<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Unauthorized access.");
}

$conn = new mysqli("localhost", "root", "", "quiz_platform");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Safely fetch POST data
$quiz_title     = $_POST['quiz_title']     ?? '';
$question       = $_POST['question']       ?? '';
$option1        = $_POST['option1']        ?? '';
$option2        = $_POST['option2']        ?? '';
$option3        = $_POST['option3']        ?? '';
$option4        = $_POST['option4']        ?? '';
$correct_option = $_POST['correct_option'] ?? '';

$success = false;
$error = '';

if ($quiz_title && $question && $option1 && $option2 && $option3 && $option4 && $correct_option) {
    $correct_option = (int)$correct_option;

    $stmt = $conn->prepare("INSERT INTO questions (quiz_title, question, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $quiz_title, $question, $option1, $option2, $option3, $option4, $correct_option);

    $success = $stmt->execute();
    $error = $stmt->error;

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Question Result</title>
  <link rel="stylesheet" href="../css/styles.css">
  <style>
    .container {
      max-width: 600px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      text-align: center;
      font-family: 'Segoe UI', sans-serif;
    }
    a {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 15px;
      text-decoration: none;
      background-color: #007bff;
      color: white;
      border-radius: 5px;
    }
    a:hover {
      background-color: #0056b3;
    }
    h2 {
      color: #333;
    }
    .error {
      color: red;
      font-weight: bold;
    }
    .success {
      color: green;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php if ($success): ?>
      <h2 class="success">✅ Question added successfully!</h2>
      <a href="../add-questions.html">➕ Add Another Question</a>
      <a href="../admin/admin-dashboard.php">🏠 Back to Dashboard</a>
    <?php else: ?>
      <h2 class="error">❌ Error adding question</h2>
      <p><?= htmlspecialchars($error ?: "Missing required input fields.") ?></p>
      <a href="../add-questions.html">🔁 Try Again</a>
    <?php endif; ?>
  </div>
</body>
</html>


















































