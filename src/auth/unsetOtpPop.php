<?php
session_start();

if (isset($_SESSION['pending-user'])) {
  unset($_SESSION['otp-pop']);
  echo 'OTP session unset.';
} else {
  echo 'Not in OTP stage.';
}
?>