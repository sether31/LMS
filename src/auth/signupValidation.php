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

  // check bday
  if($birthday_date > $current_date){
    $_SESSION['bday-error'] = "Enter a valid birthdate";
    $isError = true;
  }

  // check image
  $check_image = null;
  if(isset($_FILES['signup-picture']) && $_FILES['signup-picture']['error'] === UPLOAD_ERR_OK){

    $maxFileSize = 2 * 1024 * 1024;
    if($_FILES['signup-picture']['size'] > $maxFileSize){
      $_SESSION['picture-error'] = "Image is too large. Maximum size is 2MB.";
      $isError = true;
    }

    $image_tmp_path = $_FILES['signup-picture']['tmp_name'];
    $check_image = file_get_contents($image_tmp_path); 
  }

  // check email
  $check_email = "SELECT COUNT(*) FROM user_tb WHERE email = ?";
  $check_email = $conn->prepare($check_email);
  $check_email->bind_param("s", $signup_email);
  $check_email->execute();
  $check_email->bind_result($email_count);
  $check_email->fetch();
  $check_email->close();

  if($email_count > 0){
    $_SESSION['email-error'] = "An account with this email already exists.";
    $isError = true;
  }
  if($isError){
    header("Location: ../../pages/authentication/signup.php");
    exit();
  }

  $sql = "INSERT INTO user_tb (name, email, password, role, date_of_birth, picture) VALUES (?, ?, ?, ?, ?, ?)";
  $container = $conn->prepare($sql);
  $null = NULL;
  if(!$container){
    die("Prepare failed: " . $conn->error);
  }
  
  $container->bind_param("sssssb", 
  $signup_name, 
  $signup_email, 
  $signup_password, 
  $signup_role, 
  $signup_birthday,
  $null
  );
  
  if($check_image !== null){
    $container->send_long_data(5, $check_image); 
  }

  if($container->execute()){
    $_SESSION['register-success'] = "Let’s get cooking! Your account is ready🍽";
    header("Location: ../../pages/authentication/login.php");
    exit();
  } else{
    echo "Error executing query: " . $container->error;
  }
  $container->close();
  $conn->close();
}
?>