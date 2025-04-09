<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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

            <div class="input-box">
              <img src="../../assets/images/icons/icon-password.svg" alt="icon-password" class="icon">
              <input type="password" name="login-password" id="login-password" placeholder=" " minlength="10" required>
              <label for="login-password" class="login-password-label">Password</label>
            </div>

          <div class="check-password">
            <input type="checkbox" name="check-password" id="check-password">
            <label for="check-password">Check password</label>
          </div>

          <button type="submit">Log in</button>
        </form>

        <div class="or">
          <span class="line"></span>
          or
          <span class="line"></span>
        </div>

        <a href="./signup.php" class="dont-have-acc">Don't have an account? <span id="dont-have-acc">sign up</span></a>
      </div>
      <div class="login-right-section">
        <img src="https://static.demilked.com/wp-content/uploads/2023/06/funny-programming-memes-7-640x711.jpeg" alt="">
      </div>
    </article>
  </section>

  <script>

    const loginPassword = document.querySelector('#login-password');
    const checkPassword = document.querySelector('#check-password');

    checkPassword.addEventListener('click', ()=>{
        if (loginPassword.type === 'password') {
          loginPassword.type = 'text';  
        } else {
          loginPassword.type = 'password';  
        }
    });
  </script>
</body>
</html>