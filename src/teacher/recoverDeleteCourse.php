<?php
include '../../db/connect.php';
session_start();

if(!isset($_SESSION['user-id'])){
  die("Access denied. Please log in.");
}



if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course-id'])){
  $course_id = $_POST['course-id'];
  $sql = "update course_tb set is_delete = 0 where course_id = '$course_id'";
  $container = mysqli_query($conn, $sql);

  if($container){
      $_SESSION['recover-course-success'] = "Course recovered successfully.";
  } else{
      $_SESSION['recover-course-failed'] = "Course recover failed: " . mysqli_error($conn);
  }

  header("Location: ../../pages/teacher/course/myCourse.php");
  exit();
} else{
  $_SESSION['recover-course-error'] = "error";
  header("Location: ../../pages/teacher/course/myCourse.php");
  exit();
}

?>