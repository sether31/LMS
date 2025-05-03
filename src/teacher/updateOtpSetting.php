<?php
  session_start();
  include '../../db/connect.php';
  
  $otp = isset($_POST['otp-value']) ? 1 : 0;
  $value = $_POST['otp-value'] == 1 ? 'ON' : 'OFF';
  $sql = "update otp_switch_tb set with_otp = $otp WHERE switch_id = 1";
  $container =  mysqli_query($conn, $sql);

  if($container){
    $_SESSION['otp-switch-success'] = "OTP was successfully turn $value";
  } else{
    $_SESSION['otp-switch-failed'] = "error " . mysqli_error($conn);
  }
  header("Location: ../../pages/teacher/profile.php");
?>