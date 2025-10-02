<?php
  include 'PHPMailer/src/PHPMailer.php';
  include 'PHPMailer/src/Exception.php';
  include 'PHPMailer/src/SMTP.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  function sendOTP($to_email, $otp_code, $name, $purpose, $expires_at){
    $email = new PHPMailer(true);

    try{
      $email->isSMTP();
      $email->Host = "smtp.gmail.com"; 
      $email->SMTPAuth = true;
      $email->Username = "kitchenomachiaacademy@gmail.com";
      $email->Password = "zoxrtoykdqpidnoj"; 
      $email->SMTPSecure = "tls";
      $email->Port = 587;

      // recipient
      $email->setFrom("kitchenomachiaacademy@gmail.com","Learning Management System");
      $email->addAddress($to_email, $name);

      // content
      $email->isHTML(true);
      $email->Subject = "Learning Management System " . strtoupper($purpose) . " OTP Code";
      $email->Body = "
        <p>Hello <strong>$name</strong>,</p>
        <p>
          Your OTP code for $purpose is: 
          <strong>$otp_code</strong>
        </p>
        <p>This code will be expired at $expires_at</p>
        <br>
        <p>
          Best regards,
          <br>
          LMS
        </p>
      ";

      $email->send();
    } catch(Exception $e) {
      echo "error: {$email->ErrorInfo}";
    }
  }
?>