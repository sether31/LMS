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

    $check_quiz = "select * from quiz_tb where module_id = '$module_id'";
    $container1 = mysqli_query($conn, $check_quiz);

    if(mysqli_num_rows($container1) > 0){
      $_SESSION['quiz-create-error'] = "A quiz already exists for this module. Only one quiz per module is allowed.";
      header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
      exit();
    }

    $insert_quiz = "insert into quiz_tb (module_id, title, passing_score) values ('$module_id', '$quiz_title', '$passing_score')";
    $container2 = mysqli_query($conn, $insert_quiz);

    if($container2){
      $quiz_id = mysqli_insert_id($conn);

      for($i = 1; $i <= $question_count; $i++){
        $type = $_POST["type-$i"];
        $question = $_POST["question-$i"];
        $choice_a = $_POST["choice-$i-a"];
        $choice_b = $_POST["choice-$i-b"];
        $choice_c = $_POST["choice-$i-c"];
        $choice_d = $_POST["choice-$i-d"];

        $insert_question = "insert into quiz_question_tb (quiz_id, question_text, type, choice_a, choice_b, choice_c, choice_d) values ('$quiz_id', '$question', '$type', '$choice_a', '$choice_b', '$choice_c', '$choice_d')";
        $container3 = mysqli_query($conn, $insert_question);

        if($container3){
            $question_id = mysqli_insert_id($conn);

            if($type === 'radio'){
                $correct = mysqli_real_escape_string($conn, $_POST["answer-$i"]);
                $insertAnswerQuery = "insert into quiz_answer_key_tb (question_id, correct) values ('$question_id', '$correct')";
                mysqli_query($conn, $insertAnswerQuery);
            } else if($type === 'checkbox'){
              
              if(!empty($_POST["answer-$i"])){
                foreach ($_POST["answer-$i"] as $correct){
                  $correct = mysqli_real_escape_string($conn, $correct);
                  $insertAnswerQuery = "insert into quiz_answer_key_tb (question_id, correct) values ('$question_id', '$correct')";
                  mysqli_query($conn, $insertAnswerQuery);
                }
              }
            }
        } else{
          $_SESSION['quiz-create-error'] = "Failed to insert question $i.";
        }
      }
      $_SESSION['quiz-create-success'] = "Quiz created successfully!";
    } else{
      $_SESSION['quiz-create-error'] = "Failed to create quiz.";
    }

    header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
    exit();
  }
?>
