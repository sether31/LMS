<?php
  include '../../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])) {
    die("Access denied. Please log in.");
  }

  $user_id = $_SESSION['user-id'];
  $module_id = $_GET['moduleId'] ?? 0;
  $course_id = $_GET['courseId'] ?? 0;

  $sql = "select * from quiz_tb where module_id = $module_id";
  $container = mysqli_query($conn, $sql);
  $container = mysqli_fetch_array($container);

  if(!$container){
    die("No quiz found for this module.");
  }
  $quiz_id = $container['quiz_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../../assets/styles/student/course/takeQuiz.css">
</head>
<body>
  <a href="./viewModule.php?courseId=<?php echo $course_id ?>&moduleId=<?php echo $module_id ?>" class="back">&#8668;</a>

  <section class="container-sm">
    <div class="quiz-container">
      <h2 class="quiz-title"><?php echo $container['title'] ?></h2>

      <form method="post" action="../../../src/student/checkQuiz.php">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
        <input type="hidden" name="course-id" value="<?php echo $course_id ?>">
        <input type="hidden" name="module-id" value="<?php echo $module_id ?>">

        <?php
        $questions = mysqli_query($conn, "select * from quiz_question_tb where quiz_id = $quiz_id");
        $index = 1;

        while($q = mysqli_fetch_array($questions)):
          $question_id = $q['question_id'];
        ?>
          <div class="question-block">
            <p class="question">
              <strong>Q<?php echo $index++ ?>:</strong> 
              <?php echo $q['question_text'] ?>
            </p>
            <?php foreach(['a','b','c','d'] as $choices): ?>
              <label>
                <input type="radio" name="answers[<?php echo $question_id ?>]" value="<?php echo strtoupper($choices) ?>" required>
                <p>
                  <?php echo $q['choice_' . $choices] ?>
                </p>
              </label>
              <br>
            <?php endforeach ?>
          </div>
        <?php endwhile ?>

        <button type="submit" class="btn-primary">Submit Quiz</button>
      </form>
    </div>
  </section>
</body>
</html>
