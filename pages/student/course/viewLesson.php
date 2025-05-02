<?php
  include '../../../db/connect.php';
  session_start();
  
  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }
    
  $user_id = $_SESSION['user-id'];
  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];
  $get_lesson_id = $_GET['lessonId'];

  // lesson complete message
  $session_messages = [
    'lesson-complete-success',
    'lesson-complete-failed'
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
  <link rel="stylesheet" href="../../../assets/styles/student/course/viewLesson.css">
</head>
<body>
  <a href="./viewModule.php?courseId=<?php echo $get_course_id ?>&moduleId=<?php echo $get_module_id ?>" class="back">
    &#8668;
  </a>

  <section class="container-lg">
    <div class="wrapper">
      <?php
        $sql = "
          select l.lesson_id, l.title, l.content, l.status, vi.video_path, im.image_path
          FROM lesson_tb l
          LEFT JOIN module_tb m ON l.module_id = m.module_id
          LEFT JOIN lesson_video_tb vi ON l.lesson_id = vi.lesson_id
          LEFT JOIN lesson_image_tb im ON l.lesson_id = im.lesson_id
          WHERE l.module_id = $get_module_id and l.lesson_id = $get_lesson_id
          LIMIT 1
        ";
        
        $container = mysqli_query($conn, $sql);

        $lesson_title;
        $lesson_content;
        $lesson_status;
        $lesson_image;
        $lesson_video;

        if(mysqli_num_rows($container) > 0){
          $container = mysqli_fetch_array($container);
          $lesson_title = ucwords($container['title']);
          $lesson_content = ucfirst($container['content']);
          $lesson_status = $container['status'];
          $lesson_image = $container['image_path'] ?? 'assets/images/no-image.jpg';
          $lesson_video = $container['video_path'] ?? '';
        } else{
          echo "<p>No lessons found for module ID $get_module_id.</p>";
        }
      ?>


        <article class="media-container">
            <img src="../../../<?php echo $lesson_image; ?>" alt="image">
            <?php
              if($lesson_video){
                echo "
                  <video controls>
                    <source src='$lesson_video' type='video/mp4'>    
                  </video>
                ";
              } else{
                echo "
                  <img src='../../../assets/images/no-image.jpg' alt='image'>
                ";
              }
            ?>
        </article>


        <article class="lesson-content">
          <h2 class="title">
            <?php echo $lesson_title; ?>
          </h2>

          <p>
            <?php echo nl2br($lesson_content); ?>
          </p>

          <?php
            $sql = "select * from lesson_completion_tb where user_id = $user_id and lesson_id = $get_lesson_id";
            $container = mysqli_query($conn, $sql);

            $btn_message = 'Mark Complete'; 
            $class = 'complete-lesson-btn'; 
            $disabled = '';

            if(mysqli_num_rows($container) > 0){
              $btn_message = 'Lesson Completed &#x2713;';
              $class = 'completed-btn';
              $disabled = 'disabled';
            }
          ?>
          
          <form action="../../../src/student/completeLesson.php" method="post" class="complete-lesson-form" onsubmit="return confirm('Are you sure you finish reading <?php echo $lesson_title; ?>?');">
            <input type="hidden" name="course-id" value="<?php echo $get_course_id; ?>">
            <input type="hidden" name="module-id" value="<?php echo $get_module_id; ?>">
            <input type="hidden" name="lesson-id" value="<?php echo $get_lesson_id; ?>">
            <button type="submit" class="<?php echo $class; ?>" <?php echo $disabled; ?>>
              <?php echo $btn_message; ?>
            </button>
          </form>
        </article>
   
    </div>
  </section>
</body>
</html>