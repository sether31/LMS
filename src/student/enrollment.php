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

    $sql = "select * from student_course_tb where student_id = '$student_id' and course_id = '$course_id'";
    $container = mysqli_query($conn, $sql);

    if(mysqli_num_rows($container) > 0){
      $row = mysqli_fetch_array($container);

      if($row['status'] === 'withdrawn'){
        $re_enroll = "update student_course_tb set status = 'enrolled', enrolled_at = NOW(), finish = 0 where student_id = '$student_id' and course_id = '$course_id'";
        $container2 = mysqli_query($conn, $re_enroll);

        if($container2){
          $_SESSION['enroll-course-success'] = "Re-enrolled successfully to $course_title!";
        } else{
          $_SESSION['enroll-course-failed'] = "Failed to re-enroll: " . mysqli_error($conn);
        }
      } else{
        $_SESSION['enroll-course-failed'] = "You are already enrolled in $course_title.";
      }
    } else{
      $enroll = "insert into student_course_tb (student_id, course_id, status) values ('$student_id', '$course_id', 'enrolled')";
      $container3 = mysqli_query($conn, $enroll);

      if($container3){
        $_SESSION['enroll-course-success'] = "Enrolled successfully to $course_title!";
      } else{
        $_SESSION['enroll-course-failed'] = "Failed to enroll: " . mysqli_error($conn);
      }
    }

    header("Location: ../../pages/student/dashboard.php");
    exit();
  }
?>
