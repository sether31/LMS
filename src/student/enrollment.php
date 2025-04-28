<?php
  session_start();
  include '../../db/connect.php';

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }


  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $course_id = $_POST['course-id'];
    $course_title = $_POST['course-title'];
    $student_id = $_POST['student-id'];
  
    $sql = "insert into student_course_tb (student_id, course_id) values ('$student_id', '$course_id')";
    $container = mysqli_query($conn, $sql);
  
    if($container){
      $_SESSION['enroll-course-success'] = "Enrolled successfully to $course_title!";
      header("Location: ../../pages/student/dashboard.php");
      exit();
    } else{
      $_SESSION['enroll-course-failed'] = "Failed to enroll " . mysqli_error($conn);
      header("Location: ../../pages/student/dashboard.php");
      exit();
    }
  }

  


?>