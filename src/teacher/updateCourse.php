<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $get_course_id = $_GET['courseId'];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $update_course_title = mysqli_real_escape_string($conn, trim($_POST['update-course-title']));
    $update_course_description = mysqli_real_escape_string($conn, trim($_POST['update-course-description']));

    $sql = "update course_tb set title = '$update_course_title', description = '$update_course_description' where course_id = '$get_course_id'";
    if(mysqli_query($conn, $sql)) {
      $_SESSION['course-update-success'] = "Lesson updated successfully!";
    } else{
      $_SESSION['course-update-failed'] = "Failed to update lesson: " . mysqli_error($conn);
    }

    $check_image = null;
    
    if($_FILES['update-course-picture']['error'] === UPLOAD_ERR_OK){
      $maxFileSize = 15 * 1024 * 1024;

      if($_FILES['update-course-picture']['size'] <= $maxFileSize){
        $image_tmp = $_FILES['update-course-picture']['tmp_name'];
        $image_name = $_FILES['update-course-picture']['name'];
        $directory = '../../';
        $check_image = 'data/teacher/course/course-image/' . $image_name;
        $directory .= $check_image;

        echo $check_image;

        if(move_uploaded_file($image_tmp, $directory)){
          $sql = "update course_tb set course_image = '$check_image' where course_id = '$get_course_id'";
          mysqli_query($conn, $sql);

        } else{
          $_SESSION['course-picture-error'] = "Failed to upload the image. Please try again.";

          header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$get_course_id");
          exit();
        }
      } else{
        $_SESSION['course-picture-error'] = "Image is too large (max 15MB).";
        header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$get_course_id");
        exit();
      }
    }

    header("Location: ../../pages/teacher/course/viewCourseSettings.php?courseId=$get_course_id");
    exit();
  }
?>