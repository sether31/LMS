<?php
  include '../../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];

  // Get quiz info
  $quiz_query = "select * from quiz_tb where module_id = '$get_module_id'";
  $quiz_result = mysqli_query($conn, $quiz_query);
  $quiz = mysqli_fetch_assoc($quiz_result);

  $quiz_title = $quiz['title'];

  if(!$quiz){
    die("No quiz found to update.");
  }

  $quiz_id = $quiz['quiz_id'];

  $sql = "select * from quiz_question_tb where quiz_id = '$quiz_id'";
  $questions_result = mysqli_query($conn, $sql);

  $questions = [];
  while($row = mysqli_fetch_assoc($questions_result)){
      $question_id = $row['question_id'];
      $answer_query = "select correct from quiz_answer_key_tb where question_id = '$question_id'";
      $answer_result = mysqli_query($conn, $answer_query);
      $answers = [];
      while($a = mysqli_fetch_assoc($answer_result)){
        $answers[] = $a['correct'];
      }

      $row['answers'] = $answers;
      $questions[] = $row;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../../assets/styles/teacher/course/updateQuiz.css">
</head>
<body>

  <a href="./viewLesson.php?courseId=<?php echo $get_course_id ?>&moduleId=<?php echo $get_module_id ?>" class="back">&#8668;</a>

  <section class="container-sm quiz-container">

    <h3>Update Quiz</h3>

    <form id="quiz-form" method="post" action="../../../src/teacher/updateQuiz.php?courseId=<?php echo $get_course_id ?>&moduleId=<?php echo $get_module_id ?>&quizId=<?php echo $quiz_id ?>">
      <input type="hidden" name="question-count" value="<?php echo count($questions); ?>">

    <div class="title">
      <label for="title">Title:</label>  
      <input type="text" name="title" id="title" value="<?php echo $quiz_title; ?>">  
    </div>

      <?php foreach ($questions as $index => $q): 
        $i = $index + 1;
      ?>
      <div class="question-container">
        <fieldset>
          <legend>Question <?php echo $i; ?></legend>

          <label>Type:</label>
          <select name="type-<?php echo $i; ?>">
            <option value="radio" <?php echo $q['type'] === 'radio' ? 'selected' : ''; ?>>Single Answer</option>
            <option value="checkbox" <?php echo $q['type'] === 'checkbox' ? 'selected' : ''; ?>>Multiple Answers</option>
          </select>

          <label>Question:</label>
          <input type="text" name="question-<?php echo $i; ?>" value="<?php echo htmlspecialchars($q['question_text']); ?>">

          <?php foreach(['a', 'b', 'c', 'd'] as $choice): ?>
          <label>
            <input type="<?php echo $q['type']; ?>" name="answer-<?php echo $i; ?><?php echo $q['type'] === 'checkbox' ? '[]' : ''; ?>" value="<?php echo $choice; ?>" 
              <?php echo in_array($choice, $q['answers']) ? 'checked' : ''; ?>>
            <?php echo strtoupper($choice); ?>:
            <input type="text" name="choice-<?php echo $i; ?>-<?php echo $choice; ?>" value="<?php echo htmlspecialchars($q["choice_$choice"]); ?>">
          </label>
          <?php endforeach; ?>

        </fieldset>
      </div>
      <?php endforeach; ?>

      <button id="submit-btn" class="btn-primary" type="submit">Save Changes</button>
    </form>


    <form action="../../../src/teacher/deleteQuiz.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz?');" class="delete-quiz-form">
      <input type="hidden" name="course-id" value="<?php echo $get_course_id ?>">
      <input type="hidden" name="module-id" value="<?php echo $get_module_id ?>">
      <input type="hidden" name="quiz-id" value="<?php echo $quiz_id ?>">
      <button type="submit" class="delete-quiz">
        <img src="../../../assets/images/icons/icon-delete.svg" alt="icon-delete">
        Delete Quiz
      </button>
    </form>
  </section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('quiz-form');
    if (!form) return;

    const updateAnswerInputs = (questionIndex, newType) => {
      const inputs = form.querySelectorAll(`input[name^="answer-${questionIndex}"]`);

      inputs.forEach(input => {
        const val = input.value;
        input.type = newType;
        input.name = (newType === 'radio') 
          ? `answer-${questionIndex}` 
          : `answer-${questionIndex}[]`;
      });
    };

    const typeSelectors = form.querySelectorAll('select[name^="type-"]');
    typeSelectors.forEach((select) => {
      select.addEventListener('change', (e) => {
        const selectedType = e.target.value;
        const nameAttr = select.getAttribute('name'); 
        const questionIndex = nameAttr.split('-')[1];
        updateAnswerInputs(questionIndex, selectedType);
      });
    });
  });


</script>
</body>
</html>
