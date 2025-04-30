<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $course_id = null;

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $module_id = $_POST['module-id'];
    $course_id = $_POST['course-id'];
    $sql = "delete from quiz_tb where module_id = '$module_id'";
    $container = mysqli_query($conn, $sql);

    if($container){
      $_SESSION['quiz-delete-success'] = "Quiz deleted successfully.";
    } else{
      $_SESSION['quiz-delete-failed'] = "Failed to update quiz: " . mysqli_error($conn);
    }

    header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$course_id&moduleId=$module_id");
    exit();
  } else{
    $_SESSION['delete-course-error'] = "error";
    header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$course_id&moduleId=$module_id");
    exit();
  }
?>