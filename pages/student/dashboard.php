<?php 
  session_start();
  include '../../db/connect.php';

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $user_id = $_SESSION['user-id'];
  // enroll message
  if(isset($_SESSION['enroll-course-success'])){
    echo "
        <script>
          window.onload = ()=>{
            alert(`{$_SESSION['enroll-course-success']}`);
            }
        </script>
    ";
    unset($_SESSION['enroll-course-success']);
  }

  if(isset($_SESSION['enroll-course-failed'])){
    echo "
        <script>
          window.onload = ()=>{
            alert(`{$_SESSION['enroll-course-failed']}`);
            }
        </script>
    ";
    unset($_SESSION['enroll-course-failed']);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../assets/styles/student/dashboard.css">
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
        <img src="../../assets/images/logo/logo-w-text.png" alt="logo">
      </article>

      <nav class="nav">
        <a href="" class="active">Dashboard</a>
        <a href="">My Courses</a>
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

          $enrolled_course = [];
          $sql2 = "select course_id from student_course_tb where student_id = $user_id";
          $container2 = mysqli_query($conn, $sql2);

          if(mysqli_num_rows($container2) > 0) {
            while($row = mysqli_fetch_assoc($container2)) {
              $enrolled_course[] = $row['course_id'];
            }
          }

          $user_id =  $_SESSION['user-id'];
          $sql = "select * from course_tb where is_delete = 0 order by updated_at desc";
          $container = mysqli_query($conn, $sql);

          if(mysqli_num_rows($container) > 0){
            $course = false;
            while($row = mysqli_fetch_array($container)){
              $course_id = $row['course_id'];

              if(in_array($course_id, $enrolled_course)){
                continue; 
              }


              $course = true;
              $course_title = ucwords($row['title']);
              $course_description = ucfirst($row['description']);
              $course_picture = $row['course_image']; 
              $course_status = $row['status'];
              $title_length = 50;
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
                    <a href=''>
                      <img src='../../{$course_picture}' alt='course_picture'>
                    </a>
                  </div>
                  <div class='card-content'>
                    <a href='' class='card-title'>{$course_title}</a>
                    <p class='card-description'>{$course_description}</p>

                    <form action='../../src/student/enrollment.php' method='post' class='enrollment-form' onsubmit='return confirm(`Are you sure you want to enroll this course?`);'>
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
            if(!$course){
              echo "<h2 class='no-course'>No available courses to enroll.</h2>";
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

