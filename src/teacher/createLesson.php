<?php
include '../../db/connect.php';
session_start();

if(!isset($_SESSION['user-id'])){
  die("Access denied. Please log in.");
}

$get_course_id = $_GET['courseId'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $module_id = $_POST['module-id'];
  $lesson_title = trim($_POST['lesson-title']);
  $lesson_content = trim($_POST['lesson-content']);

  $sql = "insert into lesson_tb (module_id, title, content) values ('$module_id', '$lesson_title', '$lesson_content')";
  $container = mysqli_query($conn, $sql);

  if($container){
    $lesson_id = mysqli_insert_id($conn);
    $check_image = null;
    $check_video = null;

    if($_FILES['lesson-image']['error'] === UPLOAD_ERR_OK){
      $maxFileSize = 15 * 1024 * 1024;

      if($_FILES['lesson-image']['size'] <= $maxFileSize){
        $image_tmp_path = $_FILES['lesson-image']['tmp_name'];
        $image_name = $_FILES['lesson-image']['name'];
        $directory = '../../';
        $check_image = 'data/teacher/lesson/lesson-image/' . $image_name;
        $directory .= $check_image;

        if(move_uploaded_file($image_tmp_path, $directory)){
          $sql = "insert into lesson_image_tb (lesson_id, image_path) values ('$lesson_id', '$check_image')";
          mysqli_query($conn, $sql);
        } else{
          $_SESSION['lesson-create-image-failed'] = "Failed to upload the image. Please try again.";
          //header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$module_id");
          //exit();
        }
      } else{
        $_SESSION['lesson-create-image-failed'] = "Image is too large (max 15MB).";
        //header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$module_id");
        //exit();
      }
    }

    if($_FILES['lesson-video']['error'] === UPLOAD_ERR_OK){
      $maxFileSize = 100 * 1024 * 1024;

      if($_FILES['lesson-video']['size'] <= $maxFileSize){
        $video_tmp_path = $_FILES['lesson-video']['tmp_name'];
        $video_name = $_FILES['lesson-video']['name'];
        $directory = '../../';
        $check_video = 'data/teacher/lesson/lesson-video/' . $video_name;
        $directory .= $check_video;

        if(move_uploaded_file($video_tmp_path, $directory)) {
          $sql = "insert into lesson_video_tb (lesson_id, video_path) values ('$lesson_id', '$check_video')";
          mysqli_query($conn, $sql);
        } else{
          $_SESSION['lesson-create-video-failed'] = "Failed to upload the video. Please try again.";
          //header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$module_id");
          //exit();
        }
      } else{
        $_SESSION['lesson-create-video-failed'] = "Video is too large (max 100MB).";
        //header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$module_id");
        //exit();
      }
    }

    $_SESSION['lesson-create-success'] = "Lesson created successfully!";
    //header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$module_id");
    //exit();
  } else{
    $_SESSION['lesson-create-error'] = "Create lesson failed.";
    //header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$module_id");
    //exit();
  }
}
?>