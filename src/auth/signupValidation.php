<?php
session_start();
require_once '../../db/connect.php';

$isError = false;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $signup_name = $_POST['signup-name'];
  $signup_email = $_POST['signup-email'];
  $signup_password = password_hash($_POST['signup-password'], PASSWORD_DEFAULT);
  $signup_role = $_POST['signup-role'];
  $signup_birthday = $_POST['signup-birthday'];

  $current_date = new DateTime(); 
  $birthday_date = new DateTime($signup_birthday); 

  if($birthday_date > $current_date){
    $_SESSION['bday-error'] = "Enter a valid birthdate";
    $isError = true;
  }

  $check_image = null;
  if(isset($_FILES['signup-picture']) && $_FILES['signup-picture']['error'] === UPLOAD_ERR_OK){

    $maxFileSize = 5 * 1024 * 1024;
    if($_FILES['signup-picture']['size'] > $maxFileSize){
      $_SESSION['picture-error'] = "Image is too large. Maximum size is 5MB.";
      $isError = true;
    }

    $image_tmp_path = $_FILES['signup-picture']['tmp_name'];
    $check_image = file_get_contents($image_tmp_path); 
    $check_image = mysqli_real_escape_string($conn, $check_image); 
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
    $sql = "insert into user_tb (name, email, password, role, date_of_birth, picture) values (
      '$signup_name', 
      '$signup_email', 
      '$signup_password', 
      '$signup_role', 
      '$signup_birthday', 
      NULL)";
  } else {
    $sql = "insert into user_tb (name, email, password, role, date_of_birth, picture) values (
      '$signup_name', 
      '$signup_email', 
      '$signup_password', 
      '$signup_role', 
      '$signup_birthday', 
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