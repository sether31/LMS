<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $module_id = $_POST['module-id'];
    $course_id = $_POST['course-id'];

    $sql = "update module_tb set is_delete = 2 where module_id = '$module_id'";
    $container = mysqli_query($conn, $sql);

    if($container){
      $sql2 = "update lesson_tb set is_delete = 2 where module_id = '$module_id' and is_delete = 0";
      mysqli_query($conn, $sql2);

      $_SESSION['module-delete-success'] = "Module deleted successfully.";
    } else{
      $_SESSION['module-delete-failed'] = "Module delete failed: " . mysqli_error($conn);
    }

    header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$course_id");
    exit();
  } else{
    $_SESSION['delete-course-error'] = "error";
    header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$course_id");
    exit();
  }
?>
