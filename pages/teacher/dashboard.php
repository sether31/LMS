<?php
  include '../../src/teacher/dashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../assets/styles/teacher/dashboard.css">
</head>
<body>
  <header class="navbar">
    <section class="container-xl wrapper">
      <article id="navbar-burger">
        <span></span><span></span><span></span>
      </article>
      <article class="logo">
        <img src="../../assets/images/logo/logo-w-text.png" alt="logo">
      </article>
      <nav class="nav">
        <a class="active">Dashboard</a>
        <a href="./course/myCourse.php">My Courses</a>
        <a href="./profile.php">Profile</a>
        <a href="../../src/auth/logout.php">Logout</a>
      </nav>
    </section>
  </header>

  <section class="container-xl">
    <div class="wrapper">
      <div class="welcome-container bg-food">
        <h3>Welcome back! Admin</h3>
        <a href="./course/myCourse.php">View courses &#x27BD;</a>
      </div>
      <div class="grid-container">
        <article class="box">
          <p class="title">Total Students</p>
          <p class="value">
            <?php echo $total_students; ?>
          </p>
        </article>
        <article class="box">
          <p class="title">Total Participants</p>
          <p class="value">22</p>
        </article>
        <article class="box">
          <p class="title">Total Courses</p>
          <p class="value">
            <?php echo $total_courses; ?>
          </p>
        </article>
        <article class="box">
          <p class="title">Total Modules</p>
          <p class="value">
            <?php echo $total_modules ?>
          </p>
        </article>
        <article class="box">
          <p class="title">Total Lessons</p>
          <p class="value">
            <?php echo $total_lessons; ?>
          </p>
        </article>
        <article class="box">
          <p class="title">Students Passed</p>
          <p class="value">26</p>
        </article>
      </div>


      <h2 class="header">
        &#10070; Chart
      </h2>

      <div class="chart-container">
        <article class="box chart-box">
          <canvas id="total-module-lesson"></canvas>
          <div class="download-btn">
            <button onclick="downloadChart('total-module-lesson')">Download Chart</button>
            <button onclick="downloadCSV('total-module-lesson')">Download CSV</button>
          </div>
        </article>

        <article class="box chart-box">
          <canvas id="quiz-fail-pass-module"></canvas>
          <div class="download-btn">
            <button onclick="downloadChart('quiz-fail-pass-module')">Download Chart</button>
            <button onclick="downloadCSV('quiz-fail-pass-module')">Download CSV</button>
          </div>
        </article>

        <article class="box chart-box">
          <canvas id="total-pass-fail"></canvas>
          <div class="download-btn">
            <button onclick="downloadChart('total-pass-fail')">Download Chart</button>
            <button onclick="downloadCSV('total-pass-fail')">Download CSV</button>
          </div>
        </article>
      </div>
    </div>
  </section>

  <script src="../../scripts/utils/navbar.js"></script>
  <script type="module" src="../../scripts/teacher/dashboard.js"></script>
</body>
</html>