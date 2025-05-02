<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];
  $quiz_id = $_GET['quizId'];

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $questionCount = (int)$_POST['question-count'];

    // Delete old data
    $deleteAnswers = "DELETE quiz_answer_key_tb FROM quiz_answer_key_tb 
                      JOIN quiz_question_tb ON quiz_answer_key_tb.question_id = quiz_question_tb.question_id 
                      WHERE quiz_question_tb.quiz_id = '$quiz_id'";
    mysqli_query($conn, $deleteAnswers);

    $deleteQuestions = "DELETE FROM quiz_question_tb WHERE quiz_id = '$quiz_id'";
    mysqli_query($conn, $deleteQuestions);

    for($i=1;$i<=$questionCount;$i++){
      $question = $_POST["question-$i"];
      $choice_a = $_POST["choice-$i-a"];
      $choice_b = $_POST["choice-$i-b"];
      $choice_c = $_POST["choice-$i-c"];
      $choice_d = $_POST["choice-$i-d"];

      $insertQuestion = "INSERT INTO quiz_question_tb 
        (quiz_id, question_text, choice_a, choice_b, choice_c, choice_d)
        VALUES ('$quiz_id', '$question', '$choice_a', '$choice_b', '$choice_c', '$choice_d')";
      mysqli_query($conn, $insertQuestion);
      $question_id = mysqli_insert_id($conn);

      $correct = $_POST["answer-$i"];
      $insertAnswer = "INSERT INTO quiz_answer_key_tb (question_id, correct) VALUES ('$question_id', '$correct')";
      mysqli_query($conn, $insertAnswer);
    }

    $_SESSION['quiz-update-success'] = "Quiz updated successfully!";
    header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
    exit();
  }else{
    $_SESSION['quiz-update-failed'] = "Failed to update quiz.";
    header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
    exit();
  }
?>
