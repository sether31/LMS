<?php
  include '../../../db/connect.php';
  session_start();
  
  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }
    
  $user_id = $_SESSION['user-id'];
  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];

  // quiz take success
  $session_messages = [
    'quiz-take-success',
    'quiz-take-failed',
    'quiz-pass',
    'quiz-fail'
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
          <!-- check if lesson and complete lesson are equal if yes then allow quiz -->
          <?php
            $sql = "
              select count(l.lesson_id) as total_lessons, count(lc.lesson_id) as completed_lessons from lesson_tb l left join lesson_completion_tb lc on l.lesson_id = lc.lesson_id and lc.user_id = $user_id where l.module_id = $get_module_id and l.is_delete = 0
          ";
            $container = mysqli_query($conn, $sql);

            $row = mysqli_fetch_array($container);
        
            $total_lessons = $row['total_lessons'] ?? 0;
            $completed_lessons = $row['completed_lessons'] ?? 0;

            $check = ($total_lessons > 0 && $total_lessons == $completed_lessons);
            $disabled = $check ? '' : 'pointer-events: none; opacity: 0.8;';
            
          ?>

          <a href="./takeQuiz.php?courseId=<?php echo $get_course_id ?>&moduleId=<?php echo $get_module_id ?>" class="take-quiz-btn" style="<?php echo $disabled; ?>">
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
            <pre class="lesson-content"> &rarrlp; <?php echo ucfirst($lesson_content); ?></pre>

            <a href="./viewLesson.php?courseId=<?php echo $get_course_id ?>&moduleId=<?php echo $get_module_id ?>&lessonId=<?php echo $lesson_id ?>" class="link">
              &#x21e8; View Lesson
            </a> 
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