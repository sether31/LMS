<?php
session_start();
include '../../db/connect.php';
include '../../src/mailer/sendOTP.php';

date_default_timezone_set('Asia/Manila');

$checkForm = 'checkEmail-form';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['email'])){
    $email = trim($_POST['email']);

    $sql = "select user_id, name from user_tb where email = '$email'";
    $container = mysqli_query($conn, $sql);

    if(mysqli_num_rows($container) > 0){
      $container = mysqli_fetch_array($container);
      $user_id = $container['user_id'];
      $name = $container['name'];

      $otp_code = rand(10000, 99999);
      $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));
      $purpose = "reset password";

      $insert_sql = "insert into otp_tb (user_id, otp_code, expires_at, purpose) values ('$user_id', '$otp_code', '$expires_at', '$purpose')";

      $container = mysqli_query($conn, $insert_sql);

      $_SESSION['reset-user'] = [
        'user_id' => $user_id,
        'email' => $email,
        'name' => $name
      ];
      $checkForm = 'otp-form';

      sendOTP($email, $otp_code, $name, $purpose, $expires_at);
    } else{
      $error = "No account found with this email ($email)";
    }
  } else if(isset($_POST['otp']) && isset($_SESSION['reset-user'])){
    $otp_input = trim($_POST['otp']);
    $user_id = $_SESSION['reset-user']['user_id'];
    $purpose = "reset password";

    $sql = "select otp_code, expires_at from otp_tb where user_id = '$user_id' and purpose = '$purpose' order by created_at desc limit 1";
    $container = mysqli_query($conn, $sql);

    if(mysqli_num_rows($container) > 0){
      $container = mysqli_fetch_array($container);
      $otp_code = $container['otp_code'];
      $expires_at = $container['expires_at'];

      if($otp_input === $otp_code && strtotime($expires_at) > time()){
        $_SESSION['allow-reset'] = true;
        $checkForm = 'resetPassword-form';
      } else{
        $error = "Invalid or OTP code will be expired at: ( " . $expires_at . " )";
        $checkForm = 'otp-form';
      }
    } else{
      $error = "Error no OTP found. (on our records)";
      $checkForm = 'otp-form';
    }

  } else if(
    isset($_POST['new-password']) &&
    isset($_POST['confirm-password']) &&
    isset($_SESSION['allow-reset'])
  ){
    $new_password = trim($_POST['new-password']);
    $confirm_password = trim($_POST['confirm-password']);

    if($new_password === $confirm_password){
      $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
      $user_id = $_SESSION['reset-user']['user_id'];

      $sql = "update user_tb set password = '$hashed_password' where user_id = '$user_id'";
      $container = mysqli_query($conn, $sql);

      unset($_SESSION['reset-user'], $_SESSION['allow-reset']);
      $_SESSION['register-success'] = "Password reset successful. You can now log in.";

      header("Location: ./login.php");
      mysqli_close($conn);
      exit();
    } else{
      $error = "Passwords do not match.";
      $checkForm = 'resetPassword-form';
    }
  }
}
?>
