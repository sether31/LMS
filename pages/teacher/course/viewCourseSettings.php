<?php
  include '../../../db/connect.php';
  session_start();
  
  $get_course_id = $_GET['courseId'];
  

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }
  
  // error messages
  $session_messages = [
    'course-update-success',
    'course-update-failed',
    'course-picture-error',
    'module-create-success',
    'module-create-failed',
    'module-update-success',
    'module-update-failed',
    'module-delete-success',
    'module-delete-failed',
    'course-change-status-success',
    'course-change-status-failed',
    'module-change-status-success',
    'module-change-status-failed'
  ];

  foreach($session_messages as $key){
    if(isset($_SESSION[$key])) {
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
  <link rel="stylesheet" href="../../../assets/styles/teacher/course/viewCourseSettings.css">
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
        while($mod = mysqli_fetch_assoc($get_modules)){
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
            while($lesson = mysqli_fetch_assoc($get_lessons)){
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
          <a href="./viewCourse.php?courseId=<?php echo $get_course_id ?>">Course</a>
          <a href="" class="active">Settings</a>
          <a href="./participants.php?courseId=<?php echo $get_course_id ?>">Participants</a>
        </nav>
      </div>
      <div class="course-container">
        <div class="course-settings">
          <div class="accordion-container">

          <?php
            $sql = "select * from course_tb where course_id = '$get_course_id'";
            $container = mysqli_query($conn, $sql);
            $course_status;

            if(mysqli_num_rows($container) > 0){
              $container = mysqli_fetch_array($container);
              $course_title = $container['title'];
              $course_description = $container['description'];
              $course_picture = $container['course_image'];
              $course_status = $container['status'];
            } else{
                header('Location: ../../../pages/teacher/course.php?courseId=$get_course_id');
                exit();
            }
          ?>

            <!-- update course -->
            <div class="accordion-item" id="general">
              <input type="checkbox" id="item-1">
              <label class="accordion-title" for="item-1">
                <h3>
                  &#127859; General
                </h3>
              </label>

              <div class="accordion-content">
                <form method="POST" action="../../../src/teacher/updateCourse.php?courseId=<?php echo $get_course_id ?>" enctype="multipart/form-data">
                  <div class="left-section">
                    <div class="update-image-container"></div>
                    <small class="error-msg">
                        <?php 
                          if(isset($_SESSION['course-picture-error'])){
                            echo "({$_SESSION['course-picture-error']})";
                            unset($_SESSION['course-picture-error']);
                          }
                        ?>
                    </small>
                    <input type="file" name="update-course-picture" id="update-course-picture" accept="image/*">
                  </div>

                  <div class="right-section">
                    <div class="input-box">
                      <label for="update-course-title" class="label">Course Title:</label>
                      <input type="text" id="update-course-title" name="update-course-title"
                      value="<?php echo $course_title; ?>"
                       placeholder=" " required>
                    </div>
                      
                    <div class="input-box">
                      <label for="update-course-description">Course Description: </label>
                      <textarea name="update-course-description" id="update-course-description" placeholder=" " required><?php echo $course_description; ?></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Save and display</button>
                  </div>
                </form>
              </div>
            </div>

            <!-- create module -->
            <div class="accordion-item" id="create-module">
              <input type="checkbox" id="item-2">
              <label class="accordion-title" for="item-2">
                <span>
                  <img src="../../../assets/images/icons/icon-book-dark.svg" alt="icon-book">
                  <h3>
                    Create Module
                  </h3>
                </span>
              </label>
              <div class="accordion-content">
                <form method="POST" action="../../../src/teacher/createModule.php?courseId=<?php echo $get_course_id ?>">
                  <div class="input-box">
                    <label for="module-title" class="label">Module Title:</label>
                    <input type="text" id="module-title" name="module-title" placeholder="Enter module title" required>
                  </div>

                  <div class="input-box">
                    <label for="module-description" class="label">Module Description:</label>
                    <textarea id="module-description" name="module-description" placeholder="Enter module description" required></textarea>
                  </div>

                  <button type="submit" class="btn-primary">Create Module</button>
                </form>
              </div>
            </div>
          </div>

          <div class="module-section-header">
            <h3 class="module-head">&#10070; MODULES SECTION</h3>
            <a href="./deleteModuleList.php?courseId=<?php echo $get_course_id; ?>">Delete History &#x21dd;</a>
          </div>
          <hr class="hr">

          <?php
            $sql = "select * from module_tb where course_id = '$get_course_id' and is_delete = 0";
            $container = mysqli_query($conn, $sql);
            
            
            if(mysqli_num_rows($container) > 0):
              while($row = mysqli_fetch_array($container)):
              $module_id = $row['module_id'];
              $module_title = $row['title'];
              $module_description = $row['description'];
              $module_status = $row['status'];
          ?>    

            <!-- update module -->
            <div class="accordion-container2">
              <div class="accordion-item">
                <input type="checkbox" id="module-<?php echo $module_id; ?>">
                <label class="accordion-title" for="module-<?php echo $module_id; ?>">
                  <h3>&#127859; <?php echo $module_title; ?></h3>
                </label>
                <div class="accordion-content">
                  <div class="update-module">
                    <form method="POST" action="../../../src/teacher/updateModule.php?courseId=<?php echo $get_course_id ?>">
                      <input type="hidden" name="module-id" value="<?php echo $module_id; ?>">

                      <div class="input-box">
                        <label for="update-module-title" class="label">Module Title:</label>
                        <input type="text" id="update-module-title" name="update-module-title"
                        value="<?php echo $module_title; ?>"
                        placeholder=" " required>
                      </div>
                          
                      <div class="input-box">
                        <label for="update-module-description">Module Description: </label>
                        <textarea name="update-module-description" id="update-module-description" placeholder=" " required><?php echo $module_description; ?></textarea>
                      </div>
                      
                      <button type="submit" class="btn-primary">
                        Save and display
                      </button>
                    </form>
                  </div>

                  <br><br>

                  <?php $new_module_status = ($module_status === 'active') ? 'Inactive Module' : 'Active Module'; ?>
                
                  <div class="flex">
                    <form action="../../../src/teacher/moduleStatus.php" method="post" onsubmit="return confirm('Are you sure you want to <?php echo $new_module_status; ?> <?php echo $module_title ?>?');" class="module-status-form">
                      <input type="hidden" name="course-id" value="<?php echo $get_course_id ?>">
                      <input type="hidden" name="module-id" value="<?php echo $module_id ?>">
                      <input type="hidden" name="module-status" value="<?php echo $module_status ?>">

                      <button type="submit" class="status-module">
                        <img src="../../../assets/images/icons/icon-publish.svg" alt="icon-active">
                        <?php echo $new_module_status; ?>
                      </button>
                    </form>


                    <a href="./viewLesson.php?courseId=<?php echo $get_course_id;?>&moduleId=<?php echo $module_id;?>" class="view-lesson-btn">
                      <span>
                        <img src="../../../assets/images/icons/icon-view.svg" alt="icon-view">
                        View All lessons
                      </span>
                    </a>

                    <form action="../../../src/teacher/deleteModule.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this module?');" class="delete-module-form">
                      <input type="hidden" name="course-id" value="<?php echo $get_course_id ?>">
                      <input type="hidden" name="module-id" value="<?php echo $module_id ?>">
                      <button type="submit" class="delete-module">
                        <img src="../../../assets/images/icons/icon-delete.svg" alt="icon-delete">
                        Delete Module
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <?php endwhile; ?>
          <?php 
            else:
              echo "
                <h3 style='margin-top:3rem; text-align:center;'>
                  No Module Found.
                </h3>
              ";
            endif;
          ?>
        </div>

        <hr class="hr" style="margin-top: 5rem;">

        <div class="flex-2">
          <?php
            $sql = "select status from course_tb where course_id = '$get_course_id'";
            $container = mysqli_query($conn, $sql);

            if(mysqli_num_rows($container) > 0):
              $container = mysqli_fetch_array($container);

              $new_status = ($course_status === 'publish') ? 'unpublish' : 'publish';
          ?>


          <form action="../../../src/teacher/courseStatus.php" method="POST" onsubmit="return confirm('Are you sure you want to <?php echo $new_status; ?> <?php echo $course_title; ?>?');" class="publish-course-form">
            <input type="hidden" name="course-id" value="<?php echo $get_course_id ?>">
            <input type="hidden" name="course-status" value="<?php echo $container['status'] ?>">

            <button type="submit" class="publish-course">
              <img src="../../../assets/images/icons/icon-publish.svg" alt="icon-publish">
              <?php echo ($container['status'] === 'publish') ? 'Unpublish Course' : 'Publish Course'; ?>
            </button>
          </form>

          <form action="../../../src/teacher/deleteCourse.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');" class="delete-course-form">
            <input type="hidden" name="course-id" value="<?php echo $get_course_id ?>">
            <button type="submit" class="delete-course">
              <img src="../../../assets/images/icons/icon-delete.svg" alt="icon-delete">
              Delete Course
            </button>
          </form>
        </div>
        <?php endif;?>


      </div>
    </article>
  </section>

  <script src="../../../scripts/utils/navbar.js"></script>
  <script type="module" src="../../../scripts/teacher/viewCourseSettings.js"></script>
</body>
</html>