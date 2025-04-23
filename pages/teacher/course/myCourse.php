<?php include '../../../src/teacher/createCourse.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../../assets/styles/teacher/course/myCourse.css">
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
        <a href="../myCourse.php">Profile</a>
        <a href="../../../src/auth/logout.php">Logout</a>
      </nav>
    </section>
  </header>

  <section class="container-sm main-content">
    <article class="content-container">
      <div class="text">
        <h2>My Courses</h2>
        <h3>Course overview</h3>
      </div>
      
      <div class="action-container">
        <div class="search-bar">
          <img src="../../../assets/images/icons/icon-search.svg" alt="icon-search" class="icon">
          <input type="text" id="search-input" placeholder="Search courses..." />
        </div>
      
        <button id="add-course">
          Add Course
        </button>
      </div>

      <div class="container-grid">
        <?php
          $user_id =  $_SESSION['user-id'];
          $sql = "select * from course_tb where teacher_id = '$user_id'";
          $container = mysqli_query($conn, $sql);

          if(mysqli_num_rows($container) > 0){
            while($row = mysqli_fetch_array($container)){
              $course_title = ucwords($row['title']);
              $course_description = ucfirst($row['description']);
              $course_picture = $row['course_image']; 
              $title_length = 50;
              $description_length = 20;

              if(strlen($course_title) > $title_length){
                $course_title = substr($course_title, 0, $title_length) . "...";
              }

              if(strlen($course_description) > $description_length){
                $course_description = substr($course_description, 0, $description_length) . "...";
              }

              echo "
                <article class='card'>
                  <div class='card-image'>
                    <a href='./viewCourse.php?courseId={$row['course_id']}'>
                      <img src='../../../{$course_picture}' alt='course_picture'>
                    </a>
                  </div>
                  <div class='card-content'>
                      <a href='./viewCourse.php?courseId={$row['course_id']}' class='card-title'>
                          {$course_title}
                      </a>
                      <p class='card-description'>
                          {$course_description}
                      </p>
                  </div>
                </article>
              ";
            }
          } else{
              echo "<h2 class='no-course'>No courses found.</h2>";
          }
        ?>
      </div>
    </article>
  </section>
  
  <div id="add-course-modal" class="modal" style="<?php echo $isError ? 'display: grid;' : 'display: none;' ?>">
    <div class="modal-content">
      <p class="close-btn">&times;</p>

      <form method="POST" enctype="multipart/form-data">
        <div class="left-section">
          <div class="input-image-container"></div>
          <small class="error-msg">
              <?php 
                if(isset($_SESSION['create-image-error'])){
                  echo "({$_SESSION['create-image-error']})";
                  unset($_SESSION['create-image-error']);
                }
              ?>
          </small>
          <input type="file" name="course-image" id="course-image" accept="image/*" required>
        </div>

        <div class="right-section">
          <div class="input-box">
            <label for="course-title" class="label">Title:</label>
            <input type="text" id="course-title" name="course-title" placeholder=" " required>
          </div>
            
          <div class="input-box">
            <label for="course-description">Description: </label>
            <textarea name="course-description" id="course-description" placeholder=" " required></textarea>
          </div>
          <button type="submit" class="btn-primary">Create Course</button>
        </div>
      </form>
    </div>
  </div>
  
  <script src="../../../scripts/utils/navbar.js"></script>
  <script type="module" src="../../../scripts/teacher/myCourse.js"></script>
</body>
</html>

