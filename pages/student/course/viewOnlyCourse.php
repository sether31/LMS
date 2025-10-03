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
  <link rel="stylesheet" href="../../../assets/styles/student/course/viewOnlyCourse.css">
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

  <section class="container-md content-container">
    <article class="wrapper">
      <div class="course-container">
        <!-- display course -->
        <div class="course-content">
          <?php
            $sql = "select * from course_tb where course_id = '$get_course_id'";
            $container = mysqli_query($conn, $sql);

            $status;
            $disabled;
            $class;
            $btn_name;
            
            if(mysqli_num_rows($container) > 0){
              $container = mysqli_fetch_array($container);
              $course_title = ucwords($container['title']);
              $course_description = ucwords($container['description']);
              $course_picture = $container['course_image'];
              $course_status = $container['status'];

              $disabled = ($course_status === 'publish') ? '' : 'disabled';
              $class = ($course_status === 'publish') ? 'btn-primary' : 'btn-disabled'; 

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

        <?php     
          $sql = "select count(*) as total_modules from module_tb where is_delete = 0 and status = 'active' and course_id = '$get_course_id'";
          $container = mysqli_query($conn, $sql);
          $container = mysqli_fetch_array($container);
          $total_modules = $container['total_modules'];
          
          $sql2 = "
            select count(*) as total_lessons
            from lesson_tb l
            join module_tb m on l.module_id = m.module_id
            where l.is_delete = 0 and m.is_delete = 0 and m.course_id = '$get_course_id' and m.status = 'active'
          ";
          $container2 = mysqli_query($conn, $sql2);
          $container2 = mysqli_fetch_array($container2);
          $total_lessons = $container2['total_lessons'];    
          
          $sql3 = "
            select count(*) as total_quiz
            from quiz_tb q
            join module_tb m on q.module_id = m.module_id 
            where m.course_id = '$get_course_id' and m.is_delete = 0 and m.status = 'active'
          ";
          $container3 = mysqli_query($conn, $sql3);
          $container3 = mysqli_fetch_array($container3);
          $total_quiz = $container3['total_quiz']; 
        ?>

        <div class="card-container">
          <article class="card-course-container">
            <div class="card-course-wrapper">
              <img src="../../../assets/images/icons/icon-book-dark.svg" alt="icon-book">
              <h4 class="card-course-title">
                Total Module
              </h4>
              <h4 class="card-course-count">
                <?php echo $total_modules; ?>
              </h4>
            </div>
          </article>
          <article class="card-course-container">
            <div class="card-course-wrapper">
              <img src="../../../assets/images/icons/icon-lesson.svg" alt="icon-lesson">
              <h4 class="card-course-title">
                Total Lesson
              </h4>
              <h4 class="card-course-count">
                <?php echo $total_lessons; ?>
              </h4>
            </div>
          </article>
          <article class="card-course-container">
            <div class="card-course-wrapper">
              <img src="../../../assets/images/icons/icon-book-dark.svg" alt="icon-book">
              <h4 class="card-course-title">
                Total Quiz
              </h4>
              <h4 class="card-course-count">
                <?php echo $total_quiz; ?>
              </h4>
            </div>
          </article>
        </div>

        <form action='../../../src/student/enrollment.php' method='post' class='enrollment-form' onsubmit='return confirm(`Are you sure you want to enroll to <?php echo $course_title; ?>?`);'>
          <input type='hidden' name='course-id' value='<?php echo $get_course_id; ?>'>
          <input type='hidden' name='course-title' value='<?php echo $course_title; ?>'>
          <input type='hidden' name='student-id' value='<?php echo $user_id; ?>'>
          <button class='<?php echo $class; ?>' type='submit' <?php echo $disabled; ?>>
            Enroll
          </button>
        </form>
      </div>
    </article>
  </section>

  <script src="../../../scripts/utils/navbar.js"></script>
  <script src="../../../scripts/student/onlyViewCourse.js"></script>
</body>
</html>