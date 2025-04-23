<?php
include '../../db/connect.php';
session_start();

if(!isset($_SESSION['user-id'])){
  die("Access denied. Please log in.");
}

$course_id = null;
$module_id = null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $module_id = $_POST['module-id'];
  $course_id = $_POST['course-id'];
  $lesson_id = $_POST['lesson-id'];
  $sql = "delete from lesson_tb where lesson_id = '$lesson_id'";
  $container = mysqli_query($conn, $sql);

  if($container){
    $_SESSION['lesson-delete-success'] = "Lesson deleted successfully.";
  } else{
    $_SESSION['lesson-delete-failed'] = "Lesson delete failed: " . mysqli_error($conn);
  }

  header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$course_id&moduleId=$module_id");
  exit();
} else{
  $_SESSION['lesson-delete-error'] = "error";
  header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$course_id&moduleId=$module_id");
  exit();
}

?>