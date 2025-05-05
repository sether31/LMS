<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $course_id;
  $module_id; 

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user_id = $_SESSION['user-id'];
    $course_id = $_POST['course-id'];
    $module_id = $_POST['module-id'];

    // get answers
    $answers = $_POST['answers'] ?? [];
    $total_questions = count($answers);
    $correct_answers = 0;

    foreach($answers as $question_id => $user_answer){
      // get answer key
      $sql = "select correct from quiz_answer_key_tb where question_id = $question_id";
      $container = mysqli_query($conn, $sql);

      if(mysqli_num_rows($container) > 0){
        $correct = mysqli_fetch_array($container)['correct'];

        if(strtoupper(trim($user_answer)) === strtoupper(trim($correct))) {
          $correct_answers++;
        }
      }
    }

    // computes score
    $score = ($total_questions > 0) ? ($correct_answers / $total_questions) * 100 : 0;

    $score = round($score, 2);
    echo $score;

    // more attempt
    $sql2 = "select result_id, attempts from quiz_result_tb where user_id = $user_id and module_id = $module_id order by attempts desc limit 1";
    $container2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($container2) > 0){
      $row = mysqli_fetch_array($container2);
      $attempts = $row['attempts'] + 1;
      $result_id = $row['result_id'];

      $update = "
        update quiz_result_tb set 
        total_questions = $total_questions,
        correct_answers = $correct_answers,
        score_percentage = $score,
        attempts = $attempts
        where result_id = $result_id
      ";

      mysqli_query($conn, $update);
      $_SESSION['quiz-take-success'] = "Quiz taken successfully";
    } else{
      // 1st attempt
      $insert = "
        insert into quiz_result_tb (user_id, module_id, total_questions, correct_answers, score_percentage, attempts) values ($user_id, $module_id, $total_questions, $correct_answers, $score, 1)
      ";

      mysqli_query($conn, $insert);
      $_SESSION['quiz-take-success'] = "Quiz taken successfully";
    }
  } else{
    $_SESSION['quiz-take-failed'] = "error";
  }


   // Get the passing score from the quiz_tb
   $sql3 = "select passing_score from quiz_tb where module_id = $module_id";
   $result3 = mysqli_query($conn, $sql3);

   $passing_score = 0;
   if(mysqli_num_rows($result3) > 0){
      $passing_score = mysqli_fetch_array($result3)['passing_score'];
   }


  if ($score >= $passing_score) {
    $passed_module = "insert into module_completion_tb (user_id, module_id) values ('$user_id', '$module_id')";
    mysqli_query($conn, $passed_module);
    $_SESSION['quiz-pass'] = "You passed the quiz with the score of $correct_answers";
  } else{
    $_SESSION['quiz-fail'] = "You failed. please try again to unlock the next module.";
  }

  header("Location: ../../pages/student/course/viewModule.php?courseId=$course_id&moduleId=$module_id");
  exit();
?>
