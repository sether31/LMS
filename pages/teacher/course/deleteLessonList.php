<?php 
  include '../../../db/connect.php';
  session_start();

  // lesson recover message
  if(isset($_SESSION['recover-lesson-success'])){
    echo "
        <script>
          window.onload = ()=>{
            alert(`{$_SESSION['recover-lesson-success']}`);
            }
        </script>
    ";
    unset($_SESSION['recover-lesson-success']);
  }

  if(isset($_SESSION['recover-lesson-failed'])){
    echo "
        <script>
          window.onload = ()=>{
            alert(`{$_SESSION['recover-lesson-failed']}`);
            }
        </script>
    ";
    unset($_SESSION['recover-lesson-failed']);
  }

  if(isset($_SESSION['recover-lesson-error'])){
    echo "
        <script>
          window.onload = ()=>{
            alert(`{$_SESSION['recover-lesson-error']}`);
            }
        </script>
    ";
    unset($_SESSION['recover-lesson-error']);
  }

  $user_id = $_SESSION['user-id'];
  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../../assets/styles/teacher/course/deleteCourseList.css">
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
        <h2>&#10070; Deleted Lessons</h2>
      </div>
      
      <div class="action-container">
        <div class="mini-container">
          <div class="search-bar">
            <img src="../../../assets/images/icons/icon-search.svg" alt="icon-search" class="icon">
            <input type="text" id="search-input" placeholder="Search courses..." />
          </div>
        </div>
        <a href="./viewLesson.php?courseId=<?php echo $get_course_id; ?>&moduleId=<?php echo $get_module_id; ?>" class="back">Go back &#x21dd;</a>
      </div>


      <div class="container-grid">
        <?php
          $sql = "select * from lesson_tb where is_delete = 3 and module_id = '$get_module_id' order by updated_at desc";
          $container = mysqli_query($conn, $sql);

          if(mysqli_num_rows($container) > 0){
            while($row = mysqli_fetch_array($container)){
              $lesson_id = $row['lesson_id'];
              $lesson_title = ucwords($row['title']);
              $title_length = 50;
              if(strlen($lesson_title) > $title_length){
                $lesson_title = substr($lesson_title, 0, $title_length) . "...";
              }

              echo "
                <article class='card'>
                  <div class='card-content'>
                      <p class='card-title'>
                        {$lesson_title}
                      </p>
                      <form action='../../../src/teacher/recoverDeleteLesson.php' method='post'>
                        <input type='hidden' name='course-id' value='{$get_course_id}'>
                        <input type='hidden' name='module-id' value='{$get_module_id}'>
                        <input type='hidden' name='lesson-id' value='{$lesson_id}'>
                        <button type='submit'>
                          Recover
                        </button>
                      </form>
                  </div>
                </article>
              ";
            }
          } else{
              echo "<h2 class='no-course'>No delete of lessons found.</h2>";
          }
        ?>
      </div>
    </article>
  </section>
  

  
  <script src="../../../scripts/utils/navbar.js"></script>
  <script>
    
    const searchInput = document.querySelector('#search-input');
    const cards = document.querySelectorAll('.card');

    searchInput.addEventListener('input', function(){
      const query = this.value.toLowerCase();

      cards.forEach((card) => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        if (title.includes(query)) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  </script>
</body>
</html>

