<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!isset($_POST['question-count']) || !isset($_POST['passing-score'])){
      die("Missing question count or passing score.");
    }

    $module_id = $get_module_id;
    $question_count = (int)$_POST['question-count'];
    $passing_score = (int)$_POST['passing-score'];
    $quiz_title = $_POST['quiz-title'];

    if(!$module_id || $question_count <= 0 || $passing_score < 0 || $passing_score > 100){
      echo "Invalid module ID, question count, or passing score.";
      exit();
    }

    $check_quiz = "SELECT * FROM quiz_tb WHERE module_id = '$module_id'";
    $existing_quiz = mysqli_query($conn, $check_quiz);

    if(mysqli_num_rows($existing_quiz) > 0){
      $_SESSION['quiz-create-error'] = "A quiz already exists for this module. Only one quiz per module is allowed.";
      header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
      exit();
    }

    $insert_quiz = "INSERT INTO quiz_tb (module_id, title, passing_score) VALUES ('$module_id', '$quiz_title', '$passing_score')";
    $result_quiz = mysqli_query($conn, $insert_quiz);

    if($result_quiz){
      $quiz_id = mysqli_insert_id($conn);

      for($i = 1; $i <= $question_count; $i++){
        $question = $_POST["question-$i"];
        $choice_a = $_POST["choice-$i-a"];
        $choice_b = $_POST["choice-$i-b"];
        $choice_c = $_POST["choice-$i-c"];
        $choice_d = $_POST["choice-$i-d"];
        $correct = mysqli_real_escape_string($conn, $_POST["answer-$i"]);

        $insert_question = "INSERT INTO quiz_question_tb (quiz_id, question_text, choice_a, choice_b, choice_c, choice_d) VALUES ('$quiz_id', '$question', '$choice_a', '$choice_b', '$choice_c', '$choice_d')";
        $result_question = mysqli_query($conn, $insert_question);

        if($result_question){
          $question_id = mysqli_insert_id($conn);
          $insert_answer = "INSERT INTO quiz_answer_key_tb (question_id, correct) VALUES ('$question_id', '$correct')";
          mysqli_query($conn, $insert_answer);
        }else{
          $_SESSION['quiz-create-error'] = "Failed to insert question $i.";
        }
      }

      $_SESSION['quiz-create-success'] = "Quiz created successfully!";
    }else{
      $_SESSION['quiz-create-error'] = "Failed to create quiz.";
    }

    header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
    exit();
  }
?>
