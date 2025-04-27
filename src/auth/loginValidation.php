<?php
session_start(); 
require '../../db/connect.php';
require '../../src/mailer/sendOTP.php';

date_default_timezone_set('Asia/Manila');

if(isset($_SESSION['register-success'])){
  $message = $_SESSION['register-success'];
  echo "<script>window.onload = ()=>{ alert('$message'); };</script>";
  unset($_SESSION['register-success']);
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && 
  isset($_POST['login-email'], $_POST['login-password'])){
  $login_email = $_POST['login-email'];
  $login_password = $_POST['login-password'];

  $sql = "select user_id, name, email, password, role from user_tb where email = '$login_email'";
  $container = mysqli_query($conn , $sql);

  if($container && mysqli_num_rows($container) > 0){
    $container = mysqli_fetch_array($container);
    $user_id = $container['user_id'];
    $name = $container['name'];
    $email = $container['email'];
    $hashed_password = $container['password'];
    $role = $container['role'];
    
    if(password_verify($login_password, $hashed_password)){
      $otp_code = rand(10000, 99999);
      $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));
      $purpose = "login";

      $sql = "insert into otp_tb (user_id, otp_code, expires_at, purpose) values ('$user_id', '$otp_code', '$expires_at', '$purpose')";

      $container = mysqli_query($conn, $sql);

      $_SESSION['pending-user'] = [
        'user_id' => $user_id,
        'name' => $name,
        'email' => $email,
        'role' => $role
      ];

      $_SESSION['otp-pop'] = true;

      sendOTP($email, $otp_code, $name, $purpose, $expires_at);
    } else{
      $_SESSION['password-error'] = "Incorrect password!";
    }
  } else{
    $_SESSION['login-error'] = "No account found for this email & role.";
  }

} else if(isset($_POST['otp']) && isset($_SESSION['pending-user'])){

  $user_otp = $_POST['otp'];
  $user_id = $_SESSION['pending-user']['user_id'];
  $purpose = 'login';

  // if not set then give tries to close the otp
  if(!isset($_SESSION['otp-tries'])){
    $_SESSION['otp-tries'] = 3;
  }

  $sql = "select otp_code, expires_at from otp_tb where user_id = '$user_id' and purpose = '$purpose' order by created_at desc limit 1";
  $container = mysqli_query($conn, $sql);

  if(mysqli_num_rows($container) > 0){
    $container = mysqli_fetch_array($container);
    $otp_code = $container['otp_code'];
    $expires_at = $container['expires_at'];

    if(
      $user_otp === $otp_code && 
      strtotime($expires_at) > time() && 
      $_SESSION['otp-tries'] > 0
    ){
      $_SESSION['user-id'] = $user_id;
      $_SESSION['user-name'] = $_SESSION['pending-user']['name'];
      $_SESSION['user-email'] = $_SESSION['pending-user']['email'];
      $_SESSION['user-role'] = $_SESSION['pending-user']['role'];
   
      unset(
        $_SESSION['pending-user'],
        $_SESSION['otp-pop'],
        $_SESSION['otp-tries']
      );
  
      if($_SESSION['user-role'] === 'teacher'){
        header("Location: ../../pages/teacher/dashboard.php");
      } else{
        header("Location: ../../pages/student/dashboard.php");
      }
      mysqli_close($conn);
      exit();
    } else{
      $_SESSION['otp-tries']--;
  
      if($_SESSION['otp-tries'] <= 0){
        echo "
          <script>
            alert('Too many failed attempts. Please log in again.');
          </script>
        ";
        unset(
          $_SESSION['pending-user'],
          $_SESSION['otp-pop'],
          $_SESSION['otp-tries']
        );
      } else{
        $_SESSION['otp-error'] = "Invalid. you only have {$_SESSION['otp-tries']} attempt(s) left. <br> Your OTP will be expired at: ( " . $expires_at . " )";
      }
    }
  } else{
    $_SESSION['otp-error'] = "No OTP found for verification.";
  }
}
?>
