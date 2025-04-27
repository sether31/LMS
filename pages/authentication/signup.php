<?php require '../../src/auth/signupValidation.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../assets/styles/signup.css">
</head>
<body>
  <section class="signup-container">
    <article class="flex-container container-md">
      <div class="signup-left-section">
        <img src="../../assets/images/ka-poster.jpeg" alt="ka-poster">
      </div>
      <div class="signup-right-section">
        <div class="text">
          <img src="../../assets/images/logo/logo-w-text.png" alt="logo" id="logo">
          <h2 class="header">Create an account</h2>
        </div>

        <form action="../../src/auth/signupValidation.php" method="post" class="signup-form" enctype="multipart/form-data">
          <div class="mini-form-container">
            <div class="picture">
              <label for="signup-picture">
              Picture: 
              <small class="error-msg">
                <?php 
                  if(isset($_SESSION['picture-error'])){
                    echo "({$_SESSION['picture-error']})";
                    unset($_SESSION['picture-error']);
                  }
                ?>
              </small>
              </label>
              <br>
              <input type="file" name="signup-picture" id="signup-picture" accept="image/*" >
            </div>

            <div class="name">
              <label for="signup-name" class="signup-name-label">
              <span class="required">*</span > Name:
              </label>
              <div class="input-box">
                <img src="../../assets/images/icons/icon-name.svg" alt="icon-name" class="icon">
                <input type="text" name="signup-name" id="signup-name" minlength="5" placeholder="Enter your full name" required>
              </div>
            </div>
          </div>

          <div class="email">
            <label for="signup-email" class="signup-email-label">
            <span class="required">*</span> Email:
            <small class="error-msg">
              <?php 
                if(isset($_SESSION['email-error'])){
                  echo "({$_SESSION['email-error']})";
                  unset($_SESSION['email-error']);
                }
              ?>
            </small>
            </label>
            <div class="input-box">
              <img src="../../assets/images/icons/icon-email.svg" alt="icon-email" class="icon">
              <input type="email" name="signup-email" id="signup-email" placeholder="Enter your email" required>
            </div>
          </div>

          <div class="password">
          <label for="signup-password" class="signup-password-label">
            <span class="required">*</span> Password:
          </label>
            <div class="input-box">
              <img src="../../assets/images/icons/icon-password.svg" alt="icon-password" class="icon">
              <input type="password" name="signup-password" id="signup-password" placeholder="Must be at least 10 characters" minlength="10" required>
              <span class="eye">
                <img src="../../assets/images/icons/icon-eye-show.svg" alt="icon-eye-show" class="eye-show">
              </span>
            </div>
          </div>

          <div class="buttons">
            <button type="submit" name="register" class="btn-primary">Register</button>
            <button type="button" class="btn-secondary">
              <a href="./login.php">Log in</a>
            </button>
          </div>
        </form>
    </article>
  </section>

  <script type="module" src="../../scripts/auth/signup.js"></script>
</body>
</html>