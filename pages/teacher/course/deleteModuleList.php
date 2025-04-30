<?php 
  include '../../../db/connect.php';
  session_start();

  // module recover message
  $session_messages = [
    'recover-module-success',
    'recover-module-failed',
    'recover-module-error'
  ];

  foreach($session_messages as $key){
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

  $user_id = $_SESSION['user-id'];
  $get_course_id = $_GET['courseId'];
  
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
        <h2>&#10070; Deleted Modules</h2>
      </div>
      
      <div class="action-container">
        <div class="mini-container">
          <div class="search-bar">
            <img src="../../../assets/images/icons/icon-search.svg" alt="icon-search" class="icon">
            <input type="text" id="search-input" placeholder="Search courses..." />
          </div>
        </div>
        <a href="./viewCourseSettings.php?courseId=<?php echo $get_course_id; ?>" class="back">Go back &#x21dd;</a>
      </div>


      <div class="container-grid">
        <?php
          $sql = "select * from module_tb where is_delete = 2 and course_id = '$get_course_id' order by updated_at desc";
          $container = mysqli_query($conn, $sql);

          if(mysqli_num_rows($container) > 0){
            while($row = mysqli_fetch_array($container)){
              $module_id = $row['module_id'];
              $module_title = ucwords($row['title']);
              $title_length = 50;
              if(strlen($module_title) > $title_length){
                $module_title = substr($module_title, 0, $title_length) . "...";
              }

              echo "
                <article class='card'>
                  <div class='card-content'>
                      <p class='card-title'>
                        {$module_title}
                      </p>
                      <form action='../../../src/teacher/recoverDeleteModule.php' method='post'>
                        <input type='hidden' name='course-id' value='{$get_course_id}'>
                        <input type='hidden' name='module-id' value='{$module_id}'>
                        <button type='submit'>
                          Recover
                        </button>
                      </form>
                  </div>
                </article>
              ";
            }
          } else{
              echo "<h2 class='no-course'>No delete of modules found.</h2>";
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

