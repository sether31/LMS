<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course-id'])){
    $course_id = $_POST['course-id'];
    $course_title = $_POST['course-title'];
    $student_id = $_POST['student-id'];

    $sql = "update student_course_tb set status = 'withdrawn' where student_id = $student_id and course_id = $course_id";
    $container = mysqli_query($conn, $sql);

    if($container){
      $_SESSION['unenroll-course-success'] = "Successfully Un-enroll $course_title";
    } else{
      $_SESSION['unenroll-course-failed'] = "Course withdraw failed: " . mysqli_error($conn);
    }

    header("Location: ../../pages/student/course/myCourse.php");
    exit();
  } else{
    $_SESSION['unenroll-course-error'] = "error";
    header("Location: ../../pages/student/course/myCourse.php");
    exit();
  }
?>