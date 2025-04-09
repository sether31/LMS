<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../assets/styles/signup.css">
</head>
<body>
  <section class="signup-container">
    <article class="flex-container container-md">
      <div class="signup-left-section">
        <img src="https://static.demilked.com/wp-content/uploads/2023/06/funny-programming-memes-7-640x711.jpeg" alt="">
      </div>
      <div class="signup-right-section">
        <div class="text">
          <img src="../../assets/images/logo/logo-example.png" alt="logo" id="logo">
          <h2 class="header">Create an account</h2>
        </div>

        <form action="" method="post" class="signup-form" enctype="multipart/form-data">
          <div class="mini-form-container">
            <div class="picture">
              <label for="signup-picture">Picture:</label>
              <br>
              <input type="file" name="signup-picture" id="signup-picture" accept="image/*" required>
            </div>

            <div class="select-role">
              <label for="signup-role">Select role:</label>
              <select name="signup-role" id="signup-role" required>
                <option value="student" selected>Student</option>
                <option value="teacher">Teacher</option>
              </select>
            </div>

            <div class="bday">
              <label for="signup-bday">Birthday:</label>
              <input type="date" name="signup-birthday" id="signup-bday" required>
            </div>
          </div>

          <div class="input-box">
            <img src="../../assets/images/icons/icon-email.svg" alt="icon-email" class="icon">
            <input type="email" name="signup-email" id="signup-email" placeholder=" " required>
            <label for="signup-email" class="signup-email-label">Email</label>
          </div>

          <div class="input-box">
            <img src="../../assets/images/icons/icon-password.svg" alt="icon-password" class="icon">
            <input type="password" name="signup-password" id="signup-password" placeholder=" " minlength="10" required>
            <label for="signup-password" class="signup-password-label">Password</label>
          </div>

          <button type="submit">Register</button>
        </form>

        <div class="or">
          <span class="line"></span>
          or
          <span class="line"></span>
        </div>

        <a href="./login.php" class="have-acc">Have an account? <span id="dont-have-acc">Log in</span></a>
      </div>
    </article>
  </section>

  <script>

    const birthdayInput = document.getElementById('signup-bday');

    const today = new Date();

    const formattedDate = today.toISOString().split('T')[0];
    
    birthdayInput.addEventListener('change', ()=>{
      let check = birthdayInput.value > formattedDate;
      if(check){
        document.querySelector('#signup-bday').style.borderColor = 'var(--invalid)';
      } else{
        document.querySelector('#signup-bday').style.borderColor = 'var(--valid)';
      }
    });


  </script>
</body>
</html>