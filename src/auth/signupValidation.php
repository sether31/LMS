<?php
session_start();
require_once '../../db/connect.php';

$isError = false;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $signup_name = $_POST['signup-name'];
  $signup_email = $_POST['signup-email'];
  $signup_password = password_hash($_POST['signup-password'], PASSWORD_DEFAULT);

  $check_image = NULL;
  
  if(isset($_FILES['signup-picture']) && $_FILES['signup-picture']['error'] === UPLOAD_ERR_OK){
    $maxFileSize = 15 * 1024 * 1024;

    if($_FILES['signup-picture']['size'] > $maxFileSize){
      $_SESSION['picture-error'] = "Image is too large. (max: 15mb)";
      $isError = true;
    } else{
      $isError = false;
      $image_tmp_path = $_FILES['signup-picture']['tmp_name'];
      $image_name = $_FILES['signup-picture']['name'];
      $directory = '../../'; 
      $check_image = 'data/teacher/profile' . $image_name;
      $directory .= $check_image;

      if(move_uploaded_file($image_tmp_path, $directory)){
        
      } else{
        $_SESSION['picture-error'] = "Failed to upload the image. Please try again.";
      }
    }
  } else{
    echo "error image. please try again.";
  }

  $sql = "select count(*) as count from user_tb where email = '$signup_email'";
  $container = mysqli_query($conn, $sql);
  $container = mysqli_fetch_array($container);
  $email_count = $container['count'];

  if($email_count > 0){
    $_SESSION['email-error'] = "An account with this email already exists.";
    $isError = true;
  }

  if($isError){
    header("Location: ../../pages/authentication/signup.php");
    exit();
  }

  if($check_image === null){
    $sql = "insert into user_tb (name, email, password, picture) values (
      '$signup_name', 
      '$signup_email', 
      '$signup_password', 
      NULL)";
  } else {
    $sql = "insert into user_tb (name, email, password, picture) values (
      '$signup_name', 
      '$signup_email', 
      '$signup_password', 
      '$check_image')";
  }

  $container = mysqli_query($conn , $sql);

  if($container){
    $_SESSION['register-success'] = "Let’s get cooking! Your account is ready🍽";
    header("Location: ../../pages/authentication/login.php");
    exit();
  } else{
      echo "error: " . mysqli_error($conn);
  }
  mysqli_close($conn);
}
?>