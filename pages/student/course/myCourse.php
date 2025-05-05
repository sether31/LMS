<?php 
  session_start();
  include '../../../db/connect.php';

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $user_id = $_SESSION['user-id'];
  $alertKeys = [
      // enroll message
    'enroll-course-success',
    'enroll-course-failed',
      // un-enroll message
    'unenroll-course-success',
    'unenroll-course-failed'
  ];

  foreach ($alertKeys as $key) {
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
  <link rel="stylesheet" href="../../../assets/styles/student/course/myCourse.css">
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
        <img src="../../../assets/images/logo/logo-w-text.png" alt="logo">
      </article>

      <nav class="nav">
        <a href="../dashboard.php">Dashboard</a>
        <a class="active">My Courses</a>
        <a href="../profile.php">Profile</a>
        <a href="../../../src/auth/logout.php">Logout</a>
      </nav>
    </section>
  </header>

  <section class="container-sm main-content">
    <article class="content-container">
      <div class="text">
        <h2>&#10070; My Courses</h2>
        <h3>Course overview</h3>
      </div>
      
      <div class="action-container">
        <div class="mini-container">
          <div class="search-bar">
            <img src="../../../assets/images/icons/icon-search.svg" alt="icon-search" class="icon">
            <input type="text" id="search-input" placeholder="Search courses..." />
          </div>
        </div>
      </div>

      <div class="container-grid">
        <!-- show active enroll courses -->
        <?php
          $sql = "
            select 
              c.course_id,
              c.title,
              c.description,
              c.course_image,
              c.status,
              sc.finish,
              sc.enrolled_at
            from
              student_course_tb sc
            join 
              course_tb c on sc.course_id = c.course_id
            where 
              sc.student_id = $user_id and
              sc.status != 'withdrawn'
            order by 
              sc.enrolled_at asc
          ";
          $container = mysqli_query($conn, $sql);

          if(mysqli_num_rows($container) > 0){
            while($row = mysqli_fetch_array($container)){
              $course_id = $row['course_id'];
              $course_title = ucwords($row['title']);
              $course_description = ucfirst($row['description']);
              $course_picture = $row['course_image']; 
              $course_status = $row['status'];
              $is_finish = $row['finish'];

              $title_length = 25;
              $description_length = 20;

              if(strlen($course_title) > $title_length){
                $course_title = substr($course_title, 0, $title_length) . "...";
              }

              if(strlen($course_description) > $description_length){
                $course_description = substr($course_description, 0, $description_length) . "...";
              }

              $status = ($is_finish === '0') ? 'Ongoing' : 'Complete';
              $disabled = ($course_status === 'publish') ? '' : 'disabled';
              $class = ($course_status === 'publish') ? 'btn-primary' : 'btn-disabled'; 
              $btn_name = ($course_status === 'publish') ? 'Unenroll' : 'Maintenance'; 


              // display card
              echo "
                <article class='card'>
                  <p class='publish'>{$status}</p>
                  <div class='card-image'>
                    <a href='./viewCourse.php?courseId=$course_id' class='card-title'>
                      <img src='../../../{$course_picture}' alt='course_picture'>
                    </a>
                  </div>
                  <div class='card-content'>
                    <a href='./viewCourse.php?courseId=$course_id' class='card-title'>{$course_title}</a>
                    <p class='card-description'>{$course_description}</p>
                    <form action='../../../src/student/unEnroll.php' method='post' class='enrollment-form' onsubmit='return confirm(`Are you sure you want to un-enroll to {$course_title}?`);'>
                      <input type='hidden' name='course-id' value='$course_id'>
                      <input type='hidden' name='course-title' value='$course_title'>
                      <input type='hidden' name='student-id' value='$user_id'>
                      <button class='{$class}' title='' type='submit' {$disabled}>
                        {$btn_name}
                      </button>
                    </form>
                  </div>
                </article>
              ";
            }
          } else{
            echo "<h2 class='no-course'>No enrolled courses.</h2>";
          }
        ?>
      </div>
    </article>
  </section>
  
  <script src="../../../scripts/utils/navbar.js"></script>
  <script src="../../../scripts/student/course.myCourse.js"></script>
</body>
</html>

