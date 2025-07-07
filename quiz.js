let questions = [];
let currentQuestionIndex = 0;
let score = 0;
let timer;
let timeLeft = 30;

// Fetch questions from PHP
fetch("php/get-questions.php")
  .then((res) => res.json())
  .then((data) => {
    questions = data;
    if (questions.length > 0) {
      displayQuestion();
      startTimer();
    } else {
      document.getElementById("question-title").innerText = "⚠️ No questions found.";
    }
  })
  .catch((error) => {
    console.error("Error fetching questions:", error);
  });

// Show current question
function displayQuestion() {
  const q = questions[currentQuestionIndex];
  document.getElementById("question-title").innerText = `Q${currentQuestionIndex + 1}: ${q.question}`;

  document.getElementById("options").innerHTML = `
    <label><input type="radio" name="option" value="a"> ${q.option_a}</label><br>
    <label><input type="radio" name="option" value="b"> ${q.option_b}</label><br>
    <label><input type="radio" name="option" value="c"> ${q.option_c}</label><br>
    <label><input type="radio" name="option" value="d"> ${q.option_d}</label>
  `;
}

// Start countdown
function startTimer() {
  clearInterval(timer);
  timeLeft = 30;
  document.getElementById("time").innerText = timeLeft;

  timer = setInterval(() => {
    timeLeft--;
    document.getElementById("time").innerText = timeLeft;

    if (timeLeft <= 0) {
      goToNextQuestion(); // Auto-advance
    }
  }, 1000);
}

// Handle next button or timeout
function goToNextQuestion() {
  clearInterval(timer);

  const selectedOption = document.querySelector('input[name="option"]:checked');
  const correctAnswer = questions[currentQuestionIndex].correct_option?.toLowerCase(); // a/b/c/d

  if (selectedOption) {
    console.log(`Selected: ${selectedOption.value}, Correct: ${correctAnswer}`);
    if (selectedOption.value === correctAnswer) {
      score++;
    }
  } else {
    console.log(`No option selected. Correct: ${correctAnswer}`);
  }

  currentQuestionIndex++;

  if (currentQuestionIndex < questions.length) {
    displayQuestion();
    startTimer();
  } else {
    finishQuiz();
  }
}

// Final step: submit and redirect
function finishQuiz() {
  clearInterval(timer);

  sessionStorage.setItem("lastScore", score);
  sessionStorage.setItem("totalQuestions", questions.length);

  fetch("php/submit-score.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `quiz_title=Sample Quiz&score=${score}`
  })
    .then(() => {
      window.location.href = "score.html";
    })
    .catch((err) => {
      console.error("❌ Error submitting score:", err);
      alert("Error submitting score.");
    });
}

























































