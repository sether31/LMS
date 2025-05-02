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
  <link rel="stylesheet" href="../../../assets/styles/teacher/course/participants.css">
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
          <a href="./viewCourse.php?courseId=<?php echo $_GET['courseId']?>">Course</a>
          <a href="./viewCourseSettings.php?courseId=<?php echo $_GET['courseId']?>">Settings</a>
          <a class="active">Participants</a>
        </nav>
      </div>
      <div class="content">
        <!-- display students who enroll -->
        <?php
          $sql = "select u.name, u.email, sc.status from student_course_tb sc
          left join user_tb u on u.user_id = sc.student_id
           where sc.course_id = $get_course_id";
          $container = mysqli_query($conn, $sql);

          if (!$container) {
            die("Query failed: " . mysqli_error($conn));
          }
        ?>
        <table>
          <thead class="bg-food">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while($row = mysqli_fetch_array($container)){
              echo "
                <tr>
                  <td>{$row['name']}</td>
                  <td>{$row['email']}</td>
                  <td class='status-{$row['status']}'>{$row['status']}</td>
                </tr>
              ";
            }
            ?>
          </tbody>
        </table>
      </div>
    </article>
  </section>

  <script src="../../../scripts/utils/navbar.js"></script>
  <script src="../../../scripts/teacher/participants.js"></script>
</body>
</html>