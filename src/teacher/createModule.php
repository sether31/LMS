<?php
include '../../db/connect.php';
session_start();

if(!isset($_SESSION['user-id'])){
  die("Access denied. Please log in.");
}

$get_course_id = $_GET['courseId'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $module_title = mysqli_real_escape_string($conn, trim($_POST['module-title']));
  $module_description = mysqli_real_escape_string($conn, trim($_POST['module-description']));

  $sql = "insert into module_tb (course_id, title, description) values ('$get_course_id', '$module_title','$module_description')";

  $container = mysqli_query($conn, $sql);

  if($container) {
    $_SESSION['module-create-success'] = "Module created successfully!";
    header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$get_course_id");
    exit();
  } else {
    $_SESSION['module-create-failed'] = "Failed to update module: " . mysqli_error($conn);
    header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$get_course_id");
    exit();
  }
  header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$get_course_id");
  exit();
} 
?>
