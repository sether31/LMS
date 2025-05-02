<?php
  include '../../../db/connect.php';
  session_start();
  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];

  // get quiz title and id
  $sql = "select * from quiz_tb where module_id = '$get_module_id'";
  $container = mysqli_query($conn, $sql);
  $container = mysqli_fetch_array($container);

  if(!$container){
    die("No quiz found to update.");
  }

  $quiz_id = $container['quiz_id'];
  $quiz_title = $container['title'];

  // get the quiz question
  $sql2 = "select * from quiz_question_tb where quiz_id = '$quiz_id'";
  $container2 = mysqli_query($conn, $sql2);

  $questions = [];
  while($row = mysqli_fetch_array($container2)){
    $question_id = $row['question_id'];

    // get correct answer
    $sql3 = "select correct from quiz_answer_key_tb where question_id = '$question_id' limit 1";
    $container3 = mysqli_query($conn, $sql3);
    $correct = '';

    if($a = mysqli_fetch_array($container3)){
      $correct = strtolower(trim($a['correct']));
    }

    // put correct answer in array
    $row['correct'] = $correct;
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

      <?php foreach($questions as $i => $question): 
        $index = $i + 1;
      ?>
        <div class="question-container">
          <fieldset>
            <legend>Question <?php echo $index; ?></legend>

            <input type="hidden" name="type-<?php echo $index; ?>" value="radio">

            <label>Question:</label>
            <input type="text" name="question-<?php echo $index; ?>" value="<?php echo $question['question_text']; ?>">

            <?php foreach(['a', 'b', 'c', 'd'] as $choice): ?>
            <label>
              <input type="radio" name="answer-<?php echo $index; ?>" value="<?php echo strtoupper($choice); ?>" 
              <?php if($question['correct'] === $choice){echo 'checked';} ?>>
              <?php echo strtoupper($choice) . ':'; ?>

              <input type="text" name="choice-<?php echo $index; ?>-<?php echo $choice; ?>" value="<?php echo $question["choice_$choice"]; ?>">
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

</body>
</html>
