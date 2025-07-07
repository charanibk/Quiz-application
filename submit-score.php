<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    exit("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "", "quiz_platform");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get posted data
    $user_id = $_SESSION['user_id'];
    $quiz_title = $_POST['quiz_title'] ?? '';
    $score = $_POST['score'] ?? '';

    // Validate inputs
    if ($quiz_title === '' || $score === '') {
        exit("Missing quiz title or score.");
    }

    // Insert into scores table
    $stmt = $conn->prepare("INSERT INTO scores (user_id, quiz_title, score) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $quiz_title, $score);

    if ($stmt->execute()) {
        echo "<div class='container'><h2>✅ Score submitted successfully!</h2>
              <a href='user/user-view-score.php'>View Your Scores</a></div>";
    } else {
        echo "<div class='container'><h2>❌ Error: " . $stmt->error . "</h2></div>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
