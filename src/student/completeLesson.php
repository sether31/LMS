<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $user_id = $_SESSION['user-id'];
  $course_id;
  $module_id;

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $course_id = $_POST['course-id'];
    $module_id = $_POST['module-id'];
    $lesson_id = $_POST['lesson-id'];

    $sql = "insert into lesson_completion_tb (user_id, lesson_id) values ($user_id, $lesson_id)";
    $container = mysqli_query($conn, $sql);
    if($container){
      $_SESSION['lesson-complete-success'] = "Lesson completed";
      header("Location: ../../pages/student/course/viewLesson.php?courseId=$course_id&moduleId=$module_id&lessonId=$lesson_id");
      exit();
    } else{
      $_SESSION['lesson-complete-failed'] = "Error: " . mysqli_error($conn);
    }
  } else{
    $_SESSION['lesson-complete-failed'] = "Invalid lesson data.";
  }
?>
