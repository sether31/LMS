<?php
  include '../../../db/connect.php';
  session_start();
  
  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }
    
  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../../assets/styles/teacher/course/createQuiz.css">
</head>
<body>

  <a href="./viewLesson.php?courseId=<?php echo $get_course_id ?>&moduleId=<?php echo $get_module_id ?>" class="back">
    &#8668;
  </a>

  <section class="container-sm quiz-container">
    <h1 class="title">
      Create Quiz
    </h1>
    <div class="action-btn">
      <div class="input-box">
        <label for="num-question">
          <p>How many questions?</p>
        </label>
        <input type="number" id="num-question" placeholder="1-50" required>
      </div>

      <div class="input-box">
        <label for="passing-score">
          <p>Passing Score (%)</p>
        </label>
        <input type="number" id="passing-score" min="0" max="100" placeholder="0-100" required>
      </div>

      <button onclick="generateQuestions()">
        <span>
          <img src="../../../assets/images/icons/icon-generate.svg" alt="icon-generate">
          Generate
        </span>
      </button>
    </div>

    <form id="quiz-form" method="post" action="../../../src/teacher/createQuiz.php?courseId=<?php echo $get_course_id?>&moduleId=<?php echo $get_module_id?>"></form>
  </section>

  <script src="../../../scripts/teacher/createQuiz.js"></script>
</body>
</html>
