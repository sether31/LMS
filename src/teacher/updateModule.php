<?php
include '../../db/connect.php';
session_start();

if(!isset($_SESSION['user-id'])){
  die("Access denied. Please log in.");
}

$get_course_id = $_GET['courseId'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $module_id = $_POST['module-id'];
  $module_title = trim($_POST['update-module-title']);
  $module_description = trim($_POST['update-module-description']);

  $sql = "update module_tb set title = '$module_title', description = '$module_description' where module_id = '$module_id'";
  
  if(mysqli_query($conn, $sql)){
    $_SESSION['module-update-success'] = "Module updated successfully!";
  } else{
    $_SESSION['module-update-failed'] = "Failed to update module: " . mysqli_error($conn);
  }

  header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$get_course_id");
  exit();
}
?>
