<?php
include '../../db/connect.php';
session_start();

if(!isset($_SESSION['user-id'])){
  die("Access denied. Please log in.");
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course-id'])){
  $course_id = $_POST['course-id'];
  $sql = "delete from course_tb where course_id = '$course_id'";
  $container = mysqli_query($conn, $sql);

  if($container){
      $_SESSION['delete-course-success'] = "Course deleted successfully.";
  } else{
      $_SESSION['delete-course-failed'] = "Course delete failed: " . mysqli_error($conn);
  }

  header("Location: ../../pages/teacher/course/myCourse.php");
  exit();
} else{
  $_SESSION['delete-course-error'] = "error";
  header("Location: ../../pages/teacher/course/myCourse.php");
  exit();
}

?>