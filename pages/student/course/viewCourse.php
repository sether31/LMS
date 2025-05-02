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
  <link rel="stylesheet" href="../../../assets/styles/student/course/viewCourse.css">
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

  <section class="container-md content-container">
    <article class="wrapper">
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
            $sql = "select * from module_tb where course_id = '$get_course_id' and is_delete = 0 and status = 'active'";
            $container = mysqli_query($conn, $sql);
            $modules = [];
            while($row = mysqli_fetch_array($container)){
              $modules[] = $row; 
            }         

            foreach($modules as $index => $row):
              $module_id = $row['module_id'];
              $module_title = $row['title'];
              $module_description = $row['description'];
              $locked = false;

              if($index === 0){
                $locked = false;
              } else{
                $previous_module_passed = $modules[$index - 1]['is_pass']; 

                if($previous_module_passed == 1){
                  $locked = false; 
                } else {
                  $locked = true; 
                }
              }
            ?>
              <div class="accordion-container">
                  <div class="accordion-item <?php echo $locked ? 'locked' : ''; ?>">
                      <input type="checkbox" id="module-<?php echo $module_id ?>" <?php echo $locked ? 'disabled' : ''; ?>>
                      <label class="accordion-title" for="module-<?php echo $module_id ?>">
                          <span>
                              <img src="../../../assets/images/icons/icon-book-dark.svg" alt="icon-book">
                              <h3><?php echo ucwords($module_title); ?> <?php echo $locked ? '(&#128274; Locked)' : '&#128275;'; ?></h3>
                          </span>
                      </label>

                      <div class="accordion-content">
                          <h4 class="desc">Description</h4>
                          <p class="module-description">
                              &rarrlp; <?php echo ucfirst($module_description); ?>
                          </p>

                          <?php if(!$locked): ?>
                            <a href="./viewModule.php?courseId=<?php echo $get_course_id; ?>&moduleId=<?php echo $module_id; ?>" class="link">&#x21e8; View Module</a>
                          <?php endif; ?>
                      </div>
                  </div>
              </div>
            <?php endforeach; ?>
        </div>
      </div>
    </article>
  </section>

  <script src="../../../scripts/utils/navbar.js"></script>
  <script src="../../../scripts/student/viewCourse.js"></script>
</body>
</html>
