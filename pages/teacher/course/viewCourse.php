<?php
  include '../../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $user_id = $_SESSION['user-id'];
  $get_course_id = $_GET['courseId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../../assets/styles/teacher/course/viewCourse.css">
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
        <img src="../../../assets/images/logo/logo.png" alt="logo">
      </article>

      <nav class="nav">
        <a href="../dashboard.php">Dashboard</a>
        <a href="./myCourse.php" class="active">My Courses</a>
        <a href="../profile.php">Profile</a>
        <a href="../../../src/auth/logout.php">Logout</a>
      </nav>
    </section>
  </header>

  <div class="sidebar-hamburger-btn">
      <span></span>
      <span></span>
      <span></span>
  </div>

  <aside class="sidebar">
    <nav>
      <ul>
        <?php
        $get_modules = mysqli_query($conn, "select * from module_tb where course_id = '$get_course_id' and status = 'active' and is_delete = 0");
        while($mod = mysqli_fetch_array($get_modules)){
            $module_id = $mod['module_id'];
            $module_title = $mod['title'];
            
            echo "
            <li class='main-list'>;
              <a href='#' class='module-btn'>
                <img src='../../../assets/images/icons/icon-book-dark.svg' alt='icon-book-dark' class='icon icon-book-dark'>
                <img src='../../../assets/images/icons/icon-book-light.svg' alt='icon-book-light' class='icon icon-book-light'>

                $module_title

                <span>
                  <img src='../../../assets/images/icons/icon-arrow-dark.svg' alt='icon-arrow-dark' class='icon-arrow-dark'>
                  <img src='../../../assets/images/icons/icon-arrow-light.svg' alt='icon-arrow-light' class='icon-arrow-light'>
                </span>
              </a>  
            ";

            // Nested lessons
            $get_lessons = mysqli_query($conn, "select * from lesson_tb where module_id = '$module_id' and is_delete = 0");
            echo '<ul class="module-content">';
            while($lesson = mysqli_fetch_array($get_lessons)){
                $lesson_title = $lesson['title'];
                echo "
                  <li class='sub-list'>
                    <a href='./viewLesson.php?courseId=$get_course_id&moduleId=$module_id'>
                      <img src='../../../assets/images/icons/icon-book-dark.svg' alt='icon-book' class='icon'>
                      $lesson_title
                    </a>
                  </li>
                ";
            }
            echo '</ul>';
          echo '</li>';
        }
        ?>
      </ul>
    </nav>
  </aside>

  <section class="container-md content-container">
    <article class="wrapper">
      <div class="tabs">
        <nav>
          <a href="" class="active">Course</a>
          <a href="./viewCourseSettings.php?courseId=<?php echo $_GET['courseId']?>">Settings</a>
          <a href="./participants.php?courseId=<?php echo $_GET['courseId']?>">Participants</a>
        </nav>
      </div>
      <div class="course-container">
        <!-- display course -->
        <div class="course-content">
          <?php
            $sql = "select * from course_tb where course_id = '$get_course_id'";
            $container = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($container) > 0){
              $container = mysqli_fetch_array($container);
              $course_title = ucwords($container['title']);
              $course_description = ucwords($container['description']);
              $course_picture = $container['course_image'];

              echo "
                <div class='course-picture'>
                  <img src='../../../$course_picture' alt='course-picture'>
                </div>
                <h1 class='course-title'>$course_title</h1>
                <h4 class='desc'>Description</h4>
                <p class='course-description'>&rarrlp; $course_description</p>
              ";  
            } else{
              echo "error: " . mysqli_error($conn);
            }
          ?>
        </div>

        <hr class="hr">
        <h3 class="module-section">&#10070; MODULE SECTION</h3>
        <hr class="hr">

        <!-- display module --> 
        <div class="module-container">
          <?php
            $sql = "select * from module_tb where course_id = '$get_course_id' and is_delete = 0";
            $container = mysqli_query($conn, $sql);
            if(mysqli_num_rows($container) > 0):
              while($row = mysqli_fetch_array($container)):
                $module_id = $row['module_id'];
                $module_title = $row['title'];
                $module_description= $row['description'];
          ?>
            <div class="accordion-container">
              <div class="accordion-item">
                <input type="checkbox" id="module-<?php echo $module_id ?>">
                <label class="accordion-title" for="module-<?php echo $module_id ?>">
                  <span>
                    <img src="../../../assets/images/icons/icon-book-dark.svg" alt="icon-book">
                    <h3><?php echo ucwords($module_title); ?></h3>
                  </span>
                </label>

                <div class="accordion-content">
                  <h4 class='desc'>Description</h4>
                  <p class="module-description">
                    &rarrlp; <?php echo ucfirst($module_description); ?>
                  </p>
    
                  <hr class="hr">
                  <h3>&#10070; Lessons</h3>
                  <hr class="hr">


                  <!-- display lesson -->
                  <?php
                    $sql2 = "select * from lesson_tb where module_id = '$module_id' and is_delete = 0";
                    $container2 = mysqli_query($conn, $sql2);
                    if(mysqli_num_rows($container2) > 0):
                      while($row2 = mysqli_fetch_array($container2)):
                        $lesson_id = $row2['lesson_id'];
                        $lesson_title = $row2['title'];
                        $lesson_content = $row2['content'];
                        $lesson_content_length = 200;
                        
                        if(strlen($lesson_content) >= $lesson_content_length){
                          $lesson_content = substr($row2['content'], 0, $lesson_content_length) . "...";
                        } else{
                          $lesson_content = $row2['content'];
                        }
                  ?>
                    <div class="accordion-container2">
                      <div class="accordion-item2">
                        <input type="checkbox" id="item-<?php echo $lesson_id ?>">
                        <label class="accordion-title2" for="item-<?php echo $lesson_id ?>">
                          <span>
                            <img src="../../../assets/images/icons/icon-lesson.svg" alt="icon-lesson">
                            <h3><?php echo ucwords($lesson_title); ?></h3>
                          </span>
                        </label>

                        <div class="accordion-content2">
                        <h4 class='content'>Content</h4>
                          <p class="lesson-content">
                            &rarrlp; <?php echo ucfirst($lesson_content); ?>
                          </p>
                        </div>                      
                      </div>
                    </div>
                  <?php 
                      endwhile;
                    else:
                      echo "
                        <h4 style='margin-top:3rem; text-align:center;'>
                          No Lesson Found.
                        </h4>
                      ";
                    endif;
                  ?>
                </div>
              </div>
            </div>
          <?php 
              endwhile;
            else:
              echo "
                <h4 style='margin-top:3rem; text-align:center;'>
                  No Module Found.
                </h4>
              ";
            endif;
          ?>
        </div>
      </div>
    </article>
  </section>

  <script src="../../../scripts/utils/navbar.js"></script>
  <script src="../../../scripts/teacher/viewCourse.js"></script>
</body>
</html>