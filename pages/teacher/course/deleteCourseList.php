<?php 
  include '../../../src/teacher/createCourse.php'; 

  if(isset($_SESSION['delete-course-success'])){
    echo "
        <script>
          window.onload = ()=>{
            alert(`{$_SESSION['delete-course-success']}`);
           }
        </script>
    ";
    unset($_SESSION['delete-course-success']);
  }

  if(isset($_SESSION['delete-course-failed'])){
    echo "
        <script>
          window.onload = ()=>{
            alert(`{$_SESSION['delete-course-failed']}`);
           }
        </script>
    ";
    unset($_SESSION['delete-course-failed']);
  }
  
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
        <h2>&#10070; Deleted Course</h2>
      </div>
      
      <div class="action-container">
        <div class="mini-container">
          <div class="search-bar">
            <img src="../../../assets/images/icons/icon-search.svg" alt="icon-search" class="icon">
            <input type="text" id="search-input" placeholder="Search courses..." />
          </div>
        </div>
        <a href="./myCourse.php" class="back">Go back &#x21dd;</a>
      </div>


      <div class="container-grid">
        <?php
          $user_id =  $_SESSION['user-id'];
          $sql = "select * from course_tb where is_delete = 1 and teacher_id = '$user_id' order by updated_at asc";
          $container = mysqli_query($conn, $sql);

          if(mysqli_num_rows($container) > 0){
            while($row = mysqli_fetch_array($container)){
              $course_id = $row['course_id'];
              $course_title = ucwords($row['title']);
              $course_picture = $row['course_image']; 
              $course_status = strtoupper($row['status']);
              $title_length = 50;
              $description_length = 20;

              if(strlen($course_title) > $title_length){
                $course_title = substr($course_title, 0, $title_length) . "...";
              }

              echo "
                <article class='card'>
                  <p class='publish'>{$course_status}</p>
                  <div class='card-image'>
                    <a>
                      <img src='../../../{$course_picture}' alt='course_picture'>
                    </a>
                  </div>
                  <div class='card-content'>
                      <p class='card-title'>
                        {$course_title}
                      </p>
                      <form action='../../../src/teacher/recoverDeleteCourse.php' method='post'>
                        <input type='hidden' name='course-id' value='{$course_id}'>
                        <button type='submit'>
                          Recover
                        </button>
                      </form>
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

