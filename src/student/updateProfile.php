<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $user_id = $_SESSION['user-id'];
  $check_image = NULL;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $update_name = trim($_POST['name']);
    $update_email = trim($_POST['email']);

    $sql = "select * from user_tb where email = '$update_email' and user_id != '$user_id'";
    $container = mysqli_query($conn, $sql);

    if (mysqli_num_rows($container) > 0) {
      die("Email address already taken.");
    }

    if($_FILES['picture']['error'] === UPLOAD_ERR_OK){
      $maxFileSize = 15 * 1024 * 1024;

      if($_FILES['picture']['size'] <= $maxFileSize){
        $image_tmp_path = $_FILES['picture']['tmp_name'];
        $image_name = $_FILES['picture']['name'];
        $directory = '../../';
        $check_image = 'data/student/profile/' . $image_name;
        $directory .= $check_image;

        if(move_uploaded_file($image_tmp_path, $directory)){

        } else{
          $_SESSION['profile-update-image-failed'] = "Failed to upload the image. Please try again.";
        }
      } else{
        $_SESSION['profile-update-image-failed'] = "Image is too large (max 15MB).";
      }
    } 

    if($check_image){
      $sql = "update user_tb set name = '$update_name', email = '$update_email', picture = '$check_image' where user_id = '$user_id'";
    } else{
        $sql = "update user_tb set name = '$update_name', email = '$update_email' where user_id = '$user_id'";
    }
    $container = mysqli_query($conn, $sql);

    if($container){
      $_SESSION['profile-update-success'] = "Lesson updated successfully!";
      header("Location: ../../pages/teacher/profile.php");
      exit();
    } else{
      $_SESSION['profile-update-failed'] = "Failed to update the profile: " . mysqli_error($conn);
      header("Location: ../../pages/teacher/profile.php");
      exit();
    }
  }
?>
