<?php require '../../src/auth/loginValidation.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../assets/styles/login.css">
</head>
<body>
  <section class="login-container">
    <article class="flex-container container-md">
      <div class="login-left-section">
        <div class="text">
          <img src="../../assets/images/logo/logo-example.png" alt="logo" id="logo">
          <h1 class="header">Welcome back, Chef!</h1>
          <i class="sub-header">
            One <span>module</span> at a time, one <span>flavor</span> at a time. <span >Let’s rise!</span>
          </i>
        </div>

        <form action="" method="post" class="login-form">
          <div class="select-role">
            <label for="login-role">Select role:</label>
            <select name="login-role" id="login-role" required>
              <option value="student" selected>Student</option>
              <option value="teacher">Teacher</option>
            </select>
          </div>

          <div class="input-box">
            <img src="../../assets/images/icons/icon-email.svg" alt="icon-email" class="icon">
            <input type="email" name="login-email" id="login-email" placeholder=" " required>
            <label for="login-email" class="login-email-label">Email</label>
          </div>

          <small class="error-msg">
            <?php
              if(isset($_SESSION['login-error'])){
                echo "({$_SESSION['login-error']})";
                unset($_SESSION['login-error']);
              }
            ?>
          </small>
            
          <div class="input-box">
            <img src="../../assets/images/icons/icon-password.svg" alt="icon-password" class="icon">
            <input type="password" name="login-password" id="login-password" placeholder=" " minlength="10" required>
            <label for="login-password" class="login-password-label">Password</label>
          </div>

          <small class="error-msg">
            <?php
              if(isset($_SESSION['password-error'])){
                echo "({$_SESSION['password-error']})";
                unset($_SESSION['password-error']);
              }
            ?>
          </small>

          <div class="check-password">
            <input type="checkbox" name="check-password" id="check-password">
            <label for="check-password">Check password</label>
          </div>

          <div class="buttons">
            <button type="submit" class="btn">Log in</button>
            <a href="./signup.php" class="btn signup">
              <button type="button">
                Sign up
              </button>
            </a>
          </div>
        </form>
      </div>
      <div class="login-right-section">
        <img src="https://static.demilked.com/wp-content/uploads/2023/06/funny-programming-memes-7-640x711.jpeg" alt="">
      </div> 
    </article>
  </section>

  <script type="module" src="../../scripts/auth/login.js"></script>
</body>
</html>