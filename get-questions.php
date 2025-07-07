<?php
session_start();

// Only allow access if the user is logged in and role is 'user'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

header('Content-Type: application/json');

// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "quiz_platform");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Fetch all questions (optional: add WHERE clause for quiz_title)
$sql = "SELECT question, option1, option2, option3, option4, correct_option FROM questions";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo json_encode([]);
    $conn->close();
    exit();
}

// Convert to JSON
$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = [
        "question" => $row['question'],
        "option_a" => $row['option1'],
        "option_b" => $row['option2'],
        "option_c" => $row['option3'],
        "option_d" => $row['option4'],
        "correct_option" => optionLetter($row['correct_option']) // Convert 1/2/3/4 to a/b/c/d
    ];
}

echo json_encode($questions);
$conn->close();

// Helper function: convert numeric option to letter
function optionLetter($num) {
    switch ($num) {
        case 1: return 'a';
        case 2: return 'b';
        case 3: return 'c';
        case 4: return 'd';
        default: return '';
    }
}
?>






















