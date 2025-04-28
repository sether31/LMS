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
    $sql2 = "update module_tb set is_delete = 0 where course_id = '$course_id' and is_delete = 1";
    mysqli_query($conn, $sql2);

    $sql3 = "select module_id from module_tb where course_id = '$course_id'";
    $container2 = mysqli_query($conn, $sql3);

    while($module = mysqli_fetch_array($container2)){
      $module_id = $module['module_id'];
      $sql4 = "update lesson_tb set is_delete = 0 where module_id = '$module_id' and is_delete = 1";
      mysqli_query($conn, $sql4);
    }

      $_SESSION['recover-course-success'] = "Course recovered successfully.";
  } else{
      $_SESSION['recover-course-failed'] = "Course recover failed: " . mysqli_error($conn);
  }

  header("Location: ../../pages/teacher/course/deleteCourseList.php");
  exit();
} else{
  $_SESSION['delete-course-error'] = "error";
  header("Location: ../../pages/teacher/course/deleteCourseList.php");
  exit();
}

?>