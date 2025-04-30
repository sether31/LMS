<?php
  include '../../../db/connect.php';
  session_start();
  
  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }
    
  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../../assets/styles/student/course/viewModule.css">
</head>
<body>
  <a href="./viewCourse.php?courseId=<?php echo $get_course_id ?>" class="back">
    &#8668;
  </a>
  
  <section class="container-md content-container">
    <article class="wrapper">
      <!-- view module -->
      <?php
        $sql = "select * from module_tb where module_id = '$get_module_id'";
        $container = mysqli_query($conn, $sql);
        if(mysqli_num_rows($container) > 0):
          $container = mysqli_fetch_array($container);
        
      ?>
      <div class="module">
        <h2 class="title">
          <img src="../../../assets/images/icons/icon-book-dark.svg" alt="icon-book">
          <?php echo ucwords($container['title']) ?>
        </h2>
        <h4 class='desc'>Description</h4>
        <p class="description">
          &rarrlp; <?php echo ucfirst($container['description']) ?>
        </p>
      </div>

      <?php endif; ?>

      <hr class="hr">
      <!-- view lessons -->

      <div class="flex">
        <h3>&#10070; LESSONS SECTION</h3>
        <span>
          <a href="" class="take-quiz-btn">
            Take Quiz
          </a>
        </span>
      </div>

      <hr class="hr">

      <?php
        $sql = "select * from lesson_tb where module_id = '$get_module_id' and is_delete = 0";
        $container = mysqli_query($conn, $sql);

        if(mysqli_num_rows($container) > 0):
          while($row = mysqli_fetch_array($container)):
            $lesson_id = $row['lesson_id'];
            $lesson_title = $row['title'];
            $lesson_content = $row['content'];
            $lesson_content_length = 200;

            if(strlen($lesson_content) >= $lesson_content_length){
              $lesson_content = substr($row['content'], 0, $lesson_content_length) . "...";
            } else{
              $lesson_content = $row['content'];
            }
        ?>

      <div class="accordion-container">      
        <!-- update lesson -->
        <div class="accordion-item" id="lesson">
          <input type="checkbox" id="item-<?php echo $lesson_id?>">
          <label class="accordion-title" for="item-<?php echo $lesson_id?>">
            <span>
              <img src="../../../assets/images/icons/icon-lesson.svg" alt="icon-lesson">
              <?php echo $lesson_title ?>
            </span>
          </label>
          <div class="accordion-content">
            <pre class="lesson-content">
              &rarrlp; <?php echo ucfirst($lesson_content); ?>
            </pre>

            <a href="" class="link">&#x21e8; View Lesson</a> 
          </div>
        </div>

        <hr class="hr">
      </div>

      <?php endwhile; ?>
      <?php else: ?>
        <p>No lessons available for this module.</p>
      <?php endif; ?>
    </article>
  </section>
</body>
</html>