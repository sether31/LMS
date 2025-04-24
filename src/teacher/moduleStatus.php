<?php
session_start();
include '../../db/connect.php';

if(!isset($_SESSION['user-id'])){
  die("Access denied. Please log in.");
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $course_id = $_POST['course-id'];
  $current_status = $_POST['course-status'];

  $new_status = ($current_status === 'publish') ? 'unpublish' : 'publish';

  $sql = "update course_tb set status = '$new_status' where course_id = '$course_id'";
  $container = mysqli_query($conn, $sql);

  if($container){
    $_SESSION['module-change-status-success'] = "Course status updated to '$new_status'.";
    $_SESSION['new-module-status'] = $new_status;
  } else{
    $_SESSION['module-change-status-failed'] = "Failed to update module status.";
  }

  header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$course_id");
  exit();
}

header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$course_id");
exit();
?> 