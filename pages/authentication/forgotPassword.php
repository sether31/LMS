<?php include '../../src/auth/forgotPasswordValidation.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../assets/styles/forgotPassword.css">
</head>
<body>
  <section class="container-xl reset-password-container">
    <article class="wrapper 
    <?php echo $checkForm === 'checkEmail-form' ? 'active' : '' ?>">
      <h2>
        <span>*</span>
        Valid Email
        <span>*</span>
      </h2>
      <small class="error-msg">
        <?php 
          if(isset($error)){
            echo "($error)";
          }  
        ?>
      </small>
      <form method="POST" id="email-form">
        <label for="email">Enter your email: </label>
        <div class="input-box">
          <img src="../../assets/images/icons/icon-email.svg" class="icon" alt="icon-email">
          <input type="email" id="email" name="email" required>
        </div>
        <button type="submit" class="btn-primary">Send OTP</button>
      </form>
    </article>

    <article class="wrapper 
    <?php echo $checkForm === 'otp-form' ? 'active' : '' ?>">
      <h2>
        <span>*</span>
        OTP Code
        <span>*</span>
      </h2>
      <small class="error-msg">
        <?php 
          if(isset($error)){
            echo "($error)";
          }  
        ?>
      </small>
      <form method="POST" id="otp-form">
        <label for="otp">Enter your OTP(5): </label>
        <div class="input-box">
          <img src="../../assets/images/icons/icon-otp-key.svg" class="icon" alt="icon-otp-key">
          <input type="number" id="otp" name="otp" required>
        </div>
        <button type="submit" class="btn-primary">Verify OTP</button>
      </form> 
    </article>

    <article class="wrapper 
    <?php echo $checkForm === 'resetPassword-form' ? 'active' : '' ?>
    ">
      <h2>
        <span>*</span>
        Password Reset
        <span>*</span>
      </h2>
      <small class="error-msg">
        <?php 
          if(isset($error)){
            echo "($error)";
          }  
        ?>
      </small>
      <form method="POST" id="reset-password">
        <label for="new-password">New Password: </label>
        <div class="input-box">
          <img src="../../assets/images/icons/icon-password.svg" class="icon" alt="icon-password">
          <input type="password" id="new-password" minlength="10" name="new-password" required>
        </div>

        <label for="confirm-password">Confirm Password: </label>
        <div class="input-box">
          <img src="../../assets/images/icons/icon-password.svg" class="icon" alt="icon-password">
          <input type="password" name="confirm-password" minlength="10" required>
        </div> 
        <button type="submit" class="btn-primary">Reset Password</button>
      </form>
    </article>
  </section>
</body>
</html>
