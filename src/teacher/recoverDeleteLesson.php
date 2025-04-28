<?php
  include '../../db/connect.php';
  session_start();

  if (!isset($_SESSION['user-id'])) {
      die("Access denied. Please log in.");
  }

  $course_id = null;
  $module_id = null;

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $course_id = $_POST['course-id'];
      $module_id = $_POST['module-id'];
      $lesson_id = $_POST['lesson-id']; 

      $sql = "UPDATE lesson_tb SET is_delete = 0 WHERE lesson_id = '$lesson_id'"; 
      $container = mysqli_query($conn, $sql);

      if($container){
          $_SESSION['recover-lesson-success'] = "Lesson recovered successfully."; 
      } else{
          $_SESSION['recover-lesson-failed'] = "Lesson recovery failed: " . mysqli_error($conn);
      }

      header("Location: ../../pages/teacher/course/deleteLessonList.php?courseId=$course_id&moduleId=$module_id");
      exit();
  } else{
      $_SESSION['delete-lesson-error'] = "error";
      header("Location: ../../pages/teacher/course/deleteLessonList.php?courseId=$course_id&moduleId=$module_id");
      exit();
  }
?>
