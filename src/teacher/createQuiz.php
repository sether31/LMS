<?php
  include '../../db/connect.php';
  session_start();

  // Ensure user is logged in
  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Check if 'question-count' and 'passing-score' are set
    if (!isset($_POST['question-count']) || !isset($_POST['passing-score'])) {
      die("Invalid form data. Missing question count or passing score.");
    }

    $module_id = $get_module_id;
    $questionCount = (int)$_POST['question-count'];
    $passingScore = (int)$_POST['passing-score'];
    $quiz_title = $_POST['quiz-title'];

    if(!$module_id || $questionCount <= 0 || $passingScore < 0 || $passingScore > 100){
      echo "Invalid module ID, question count, or passing score.";
      exit();
    }

    // Check if a quiz already exists for the module
    $checkQuizQuery = "SELECT * FROM quiz_tb WHERE module_id = '$module_id'";
    $checkQuizResult = mysqli_query($conn, $checkQuizQuery);

    if(mysqli_num_rows($checkQuizResult) > 0){
      $_SESSION['quiz-create-error'] = "A quiz already exists for this module. Only one quiz per module is allowed.";
      header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
      exit();
    }

    // Insert quiz into the database with passing score
    $insertQuizQuery = "INSERT INTO quiz_tb (module_id, title, passing_score) VALUES ('$module_id', '$quiz_title', '$passingScore')";
    $quiz_result = mysqli_query($conn, $insertQuizQuery);

    if($quiz_result){
      $quiz_id = mysqli_insert_id($conn);

      for($i = 1; $i <= $questionCount; $i++){
        $type = mysqli_real_escape_string($conn, $_POST["type-$i"]);
        $question = mysqli_real_escape_string($conn, $_POST["question-$i"]);
        $choice_a = mysqli_real_escape_string($conn, $_POST["choice-$i-a"]);
        $choice_b = mysqli_real_escape_string($conn, $_POST["choice-$i-b"]);
        $choice_c = mysqli_real_escape_string($conn, $_POST["choice-$i-c"]);
        $choice_d = mysqli_real_escape_string($conn, $_POST["choice-$i-d"]);

          // Insert question into the quiz
        $insertQuestionQuery = "INSERT INTO quiz_question_tb (quiz_id, question_text, type, choice_a, choice_b, choice_c, choice_d) 
                                  VALUES ('$quiz_id', '$question', '$type', '$choice_a', '$choice_b', '$choice_c', '$choice_d')";
        $question_result = mysqli_query($conn, $insertQuestionQuery);

        if($question_result){
            $question_id = mysqli_insert_id($conn);

            // Handle answers based on question type (radio or checkbox)
            if($type === 'radio'){
                $correct = mysqli_real_escape_string($conn, $_POST["answer-$i"]);
                $insertAnswerQuery = "INSERT INTO quiz_answer_key_tb (question_id, correct) VALUES ('$question_id', '$correct')";
                mysqli_query($conn, $insertAnswerQuery);
            } else if($type === 'checkbox'){
              
              if(!empty($_POST["answer-$i"])){
                foreach ($_POST["answer-$i"] as $correct){
                  $correct = mysqli_real_escape_string($conn, $correct);
                  $insertAnswerQuery = "INSERT INTO quiz_answer_key_tb (question_id, correct) VALUES ('$question_id', '$correct')";
                  mysqli_query($conn, $insertAnswerQuery);
                }
              }
            }
        } else{
            $_SESSION['quiz-create-error'] = "Failed to insert question $i.";
        }
      }

      // Success message
      $_SESSION['quiz-create-success'] = "Quiz created successfully!";
    } else{
      // Failure message for quiz insert
      $_SESSION['quiz-create-error'] = "Failed to create quiz.";
    }

    header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
    exit();
  }
?>
