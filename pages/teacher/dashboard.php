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
          <p class="title">Total Publish Courses</p>
          <p class="value">
            <?php echo $total_publish_courses; ?>
          </p>
        </article>
        <article class="box">
          <p class="title">Total Unpublish Courses</p>
          <p class="value">
            <?php echo $total_unpublish_courses; ?>
          </p>
        </article>
        <article class="box">
          <p class="title">Total Active Modules</p>
          <p class="value">
            <?php echo $total_active_modules; ?>
          </p>
        </article>
        <article class="box">
          <p class="title">Total Inactive Modules</p>
          <p class="value">
            <?php echo $total_inactive_modules; ?>
          </p>
        </article>
        <article class="box">
          <p class="title">Total Active Lessons</p>
          <p class="value">
            <?php echo $total_active_lessons; ?>
          </p>
        </article>
        <article class="box">
          <p class="title">Total Inactive Lessons</p>
          <p class="value">
            <?php echo $total_inactive_lessons; ?>
          </p>
        </article>
      </div>


      <h2 class="header">
        &#10070; Chart
      </h2>

      <div class="chart-container">
        <article class="box chart-box">
          <canvas id="total-module-lesson"></canvas>
        </article>

        <article class="box chart-box">
          <canvas id="total-attempts"></canvas>
        </article>
      </div>
    </div>
  </section>

  

  <script src="../../scripts/utils/navbar.js"></script>
  <script type="module" src="../../scripts/teacher/dashboard.js"></script>
</body>
</html>