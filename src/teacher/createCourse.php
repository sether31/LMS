<?php
session_start();
include '../../../db/connect.php';

if(!isset($_SESSION['user-id'])){
  die("Access denied. Please log in.");
}


$isError = false;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $user_id = $_SESSION['user-id'];
  $course_title = $_POST['course-title'];
  $course_description = $_POST['course-description'];

  $check_image = NULL;

  if(isset($_FILES['course-image']) && $_FILES['course-image']['error'] === UPLOAD_ERR_OK){
    $maxFileSize = 10 * 1024 * 1024;

    if($_FILES['course-image']['size'] > $maxFileSize){
      $_SESSION['image-error'] = "Image is too large. (max: 10mb)";
      $isError = true;
    } else{
      $isError = false;
      $image_tmp_path = $_FILES['course-image']['tmp_name'];
      $image_name = $_FILES['course-image']['name'];
      $directory = '../../../'; 
      $check_image = 'data/teacher/course/course-image/' . $image_name;
      $directory .= $check_image;

      if(move_uploaded_file($image_tmp_path, $directory)) {
        $sql = "insert into course_tb (teacher_id, course_image, title, description) values ('$user_id', '$check_image', '$course_title', '$course_description')";
        mysqli_query($conn , $sql);
        $_SESSION['create-course-success'] = "Created course successfully!";
        header("Location: ./myCourse.php");
        exit();
      } else{
        $_SESSION['create-image-error'] = "Failed to upload the image. Please try again.";
      }
    }
  } else{
    $_SESSION['create-image-error'] = "error";
  }
}
?>