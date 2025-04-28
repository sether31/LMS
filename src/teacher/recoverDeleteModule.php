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

    $sql = "update module_tb set is_delete = 0 where module_id = '$module_id' and is_delete = 2";
    $container = mysqli_query($conn, $sql);

    if($container){
      $sql2 = "update lesson_tb set is_delete = 0 where module_id = '$module_id' and is_delete = 2";
      mysqli_query($conn, $sql2);

      $_SESSION['recover-module-success'] = "Module recovered successfully.";
    } else{
      $_SESSION['recover-module-failed'] = "Module recovery failed: " . mysqli_error($conn);
    }

    header("Location: ../../pages/teacher/course/deleteModuleList.php?courseId=$course_id");
    exit();
  } else{
    $_SESSION['delete-module-error'] = "error";
    header("Location: ../../pages/teacher/course/deleteModuleList.php?courseId=$course_id");
    exit();
  }

?>