<?php
include '../../db/connect.php';
session_start();

if (!isset($_SESSION['user-id'])) {
  die("Access denied. Please log in.");
}

$get_course_id = $_GET['courseId'];
$get_module_id = $_GET['moduleId'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $lesson_id = $_POST['lesson-id'];
  $update_lesson_title = trim($_POST['update-lesson-title']);
  $update_lesson_content = trim($_POST['update-lesson-content']);

  $sql = "update lesson_tb set title = '$update_lesson_title', content = '$update_lesson_content' where lesson_id = '$lesson_id'";
  if(mysqli_query($conn, $sql)){
    $_SESSION['lesson-update-success'] = "Lesson updated successfully!";
  } else{
    $_SESSION['lesson-update-failed'] = "Failed to update lesson: " . mysqli_error($conn);
  }

  $check_image = null;
  $check_video = null;

  if($_FILES['update-lesson-image']['error'] === UPLOAD_ERR_OK){
    $maxFileSize = 10 * 1024 * 1024;

    if($_FILES['update-lesson-image']['size'] <= $maxFileSize){
      $image_tmp = $_FILES['update-lesson-image']['tmp_name'];
      $image_name = $_FILES['update-lesson-image']['name'];
      $directory = '../../';
      $check_image = 'data/teacher/lesson/lesson-image/' . $image_name;
      $directory .= $check_image;

      if(move_uploaded_file($image_tmp, $directory)){
        $sql = "select * from lesson_image_tb where lesson_id = '$lesson_id'";
        $container = mysqli_query($conn, $sql);

        if(mysqli_num_rows($container) > 0){
          mysqli_query($conn, "update lesson_image_tb set image_path = '$check_image' where lesson_id = '$lesson_id'");
          $_SESSION['lesson-update-success'] = "Lesson updated successfully!";
        } else{
          mysqli_query($conn, "insert into lesson_image_tb (lesson_id, image_path) values ('$lesson_id', '$check_image')");
          $_SESSION['lesson-update-success'] = "Lesson updated successfully!";
        }
      } else{
        $_SESSION['lesson-update-image-error'] = "Failed to update the image. Please try again.";
        header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
        exit();
      }
    } else{
      $_SESSION['lesson-update-image-failed'] = "Image is too large (max 10MB).";
      header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
      exit();
    }
  }


  if($_FILES['update-lesson-video']['error'] === UPLOAD_ERR_OK){
    $maxFileSize = 100 * 1024 * 1024;

    if($_FILES['update-lesson-video']['size'] <= $maxFileSize){
      $video_tmp = $_FILES['update-lesson-video']['tmp_name'];
      $video_name = $_FILES['update-lesson-video']['name'];
      $directory = '../../';
      $check_video = 'data/teacher/lesson/lesson-video/' . $video_name;
      $directory .= $check_video;

      if(move_uploaded_file($video_tmp, $directory)){
        $sql = "select * from lesson_video_tb where lesson_id = '$lesson_id'";
        $container = mysqli_query($conn, $sql);

        if(mysqli_num_rows($container) > 0){
          mysqli_query($conn, "update lesson_video_tb set video_path = '$check_video' where lesson_id = '$lesson_id'");
          $_SESSION['lesson-update-success'] = "Lesson updated successfully!";
        } else{
          mysqli_query($conn, "insert into lesson_video_tb (lesson_id, video_path) values ('$lesson_id', '$check_video')");
          $_SESSION['lesson-update-success'] = "Lesson updated successfully!";
        }
      } else{
        $_SESSION['lesson-update-video-error'] = "Failed to update video. Please try again.";
        header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
        exit();
      }
    } else{
      $_SESSION['lesson-update-video-failed'] = "Video is too large (max 100MB).";
      header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
      exit();
    }
  }

  // Redirect to course settings view
  header("Location: ../../pages/teacher/course/viewLesson.php?courseId=$get_course_id&moduleId=$get_module_id");
  exit();
}

?>
