<?php 
  session_start();
  include '../../db/connect.php';

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $user_id = $_SESSION['user-id'];
  
  // enroll message
  $session_messages = [
    'enroll-course-success',
    'enroll-course-failed'
  ];

  foreach($session_messages as $key){
    if(isset($_SESSION[$key])){
      echo "
        <script>
          window.onload = () => {
            alert(`{$_SESSION[$key]}`);
          }
        </script>
      ";
      unset($_SESSION[$key]);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../assets/styles/student/course/myCourse.css">
</head>
<body>
  <header class="navbar">
    <section class="container-xl wrapper">
      <article id="navbar-burger">
        <span></span>
        <span></span>
        <span></span>
      </article>

      <article class="logo">
        <img src="../../assets/images/logo/logo.png" alt="logo">
      </article>

      <nav class="nav">
        <a href="" class="active">Dashboard</a>
        <a href="./course/myCourse.php">My Courses</a>
        <a href="./profile.php">Profile</a>
        <a href="../../src/auth/logout.php">Logout</a>
      </nav>
    </section>
  </header>

  <section class="container-sm main-content">
    <article class="content-container">
      <div class="text">
        <h2>&#10070; Courses</h2>
        <h3>Course overview</h3>
      </div>
      
      <div class="action-container">
        <div class="mini-container">
          <div class="search-bar">
            <img src="../../assets/images/icons/icon-search.svg" alt="icon-search" class="icon">
            <input type="text" id="search-input" placeholder="Search courses..." />
          </div>
        </div>
      </div>

      <div class="container-grid">
        <?php
          $user_id =  $_SESSION['user-id'];
          $sql = "select * from course_tb where is_delete = 0 and course_id not in (select course_id from student_course_tb where student_id = $user_id and status = 'enrolled') order by updated_at asc";

          $container = mysqli_query($conn, $sql);

          if(mysqli_num_rows($container) > 0){
            $course = false;
            while($row = mysqli_fetch_array($container)){
              $course_id = $row['course_id'];

              $course_title = ucwords($row['title']);
              $course_description = ucfirst($row['description']);
              $course_picture = $row['course_image']; 
              $course_status = $row['status'];
              $title_length = 25;
              $description_length = 20;

              if(strlen($course_title) > $title_length){
                $course_title = substr($course_title, 0, $title_length) . "...";
              }

              if(strlen($course_description) > $description_length){
                $course_description = substr($course_description, 0, $description_length) . "...";
              }

              $status = ($course_status === 'publish') ? 'Available' : 'To be posted';
              $title = ($course_status === 'publish') ? 'Enroll now' : 'This course is not available yet..';
              $class = ($course_status === 'publish') ? 'btn-primary' : 'btn-disabled';
              $disabled = ($course_status === 'publish') ? '' : 'disabled';

              echo "
                <article class='card'>
                  <p class='publish'>{$status}</p>
                  <div class='card-image'>
                    <a href='./course/viewOnlyCourse.php?courseId=$course_id'>
                      <img src='../../{$course_picture}' alt='course_picture'>
                    </a>
                  </div>
                  <div class='card-content'>
                    <a href='./course/viewOnlyCourse.php?courseId=$course_id' class='card-title'>{$course_title}</a>
                    <p class='card-description'>{$course_description}</p>

                    <form action='../../src/student/enrollment.php' method='post' class='enrollment-form' onsubmit='return confirm(`Are you sure you want to enroll to {$course_title}?`);'>
                      <input type='hidden' name='course-id' value='$course_id'>
                      <input type='hidden' name='course-title' value='$course_title'>
                      <input type='hidden' name='student-id' value='$user_id'>
                      <button class='{$class}' title='{$title}' type='submit' {$disabled}>
                        Enroll
                      </button>
                    </form>
                  </div>
                </article>
              ";
            }
          } else{
            echo "<h2 class='no-course'>No courses available.</h2>";
          }
         
        ?>
      </div>
    </article>
  </section>
  
  <script src="../../scripts/utils/navbar.js"></script>
  <script src="../../scripts/student/dashboard.js"></script>
</body>
</html>

