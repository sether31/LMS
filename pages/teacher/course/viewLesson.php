<?php
  include '../../../db/connect.php';
  session_start();
  
  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }
    
  $get_course_id = $_GET['courseId'];
  $get_module_id = $_GET['moduleId'];
  
  $session_messages = [
    // Lesson update
    'lesson-update-success',
    'lesson-update-failed',
    'lesson-update-image-failed',
    'lesson-update-image-error',
    'lesson-update-video-failed',
    'lesson-video-error',
  
    // Lesson create
    'lesson-create-success',
    'lesson-create-failed',
    'lesson-create-video-failed',
    'lesson-create-success-failed',
  
    // Lesson delete
    'lesson-delete-success',
    'lesson-delete-failed',
    'lesson-delete-error',
  
    // Quiz create
    'quiz-create-success',
    'quiz-create-error',
  
    // Quiz update
    'quiz-update-success',
    'quiz-update-failed',
  
    // Quiz delete
    'quiz-delete-success',
    'quiz-delete-failed'
  ];
  
  foreach ($session_messages as $key) {
    if (isset($_SESSION[$key])) {
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
  <link rel="stylesheet" href="../../../assets/styles/teacher/course/viewLesson.css">
</head>
<body>
  <a href="./viewCourseSettings.php?courseId=<?php echo $get_course_id ?>" class="back">
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

        <a href="./deleteLessonList.php?courseId=<?php echo $get_course_id ?>&moduleId=<?php echo $get_module_id ?>" class="link">Delete History &#x21dd;</a>
      </div>

      <?php endif; ?>

      <hr class="hr">
      <!-- lessons -->

      <div class="flex">
        <h3>&#10070; LESSONS SECTION</h3>
        <span>
          <a href="./createLesson.php?courseId=<?php echo $get_course_id;?>&moduleId=<?php echo $get_module_id;?>" class="create-lesson-btn">
            Create lesson
          </a>
          <?php 
              $sql = "select * from quiz_tb where module_id = '$get_module_id'";
              $container = mysqli_query($conn, $sql);
              
              if(mysqli_num_rows($container) > 0): 
                $container = mysqli_fetch_array($container);
                $_SESSION['quiz-id'] = $container['quiz_id'];
          ?>
            <a href="./updateQuiz.php?courseId=<?php echo $get_course_id;?>&moduleId=<?php echo $get_module_id;?>" class="create-quiz-btn">
              Edit Quiz
            </a>
          <?php else: ?>
            <a href="./createQuiz.php?courseId=<?php echo $get_course_id;?>&moduleId=<?php echo $get_module_id;?>" class="create-quiz-btn">
              Create Quiz
            </a>
          <?php endif; ?>
        </span>
      </div>

      <hr class="hr">

      <?php
        $sql = "select * from lesson_tb where module_id = '$get_module_id' and is_delete = 0";
        $container = mysqli_query($conn, $sql);

        if(mysqli_num_rows($container) > 0):
          while($lesson = mysqli_fetch_array($container)):
            $lesson_id = $lesson['lesson_id'];
            $lesson_title = $lesson['title'];
            $lesson_content = $lesson['content'];

            $img_sql = mysqli_query($conn, "select * from lesson_image_tb where lesson_id = '$lesson_id'");
            $container1 = mysqli_fetch_array($img_sql);
            $lesson_image = $container1['image_path'] ?? null;

            $vide_sql = mysqli_query($conn, "select * from lesson_video_tb where lesson_id = '$lesson_id'");
            $container2 = mysqli_fetch_array($vide_sql);
            $lesson_video = $container2['video_path'] ?? null;
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
            <form method="POST" action="../../../src/teacher/updateLesson.php?courseId=<?php echo $get_course_id ?>&moduleId=<?php echo $get_module_id ?>" enctype="multipart/form-data">

              <input type="hidden" name="lesson-id" value="<?php echo $lesson_id ?>">

              <div class="media-container">
                <div class=" image">
                  <label>Current Image:</label>
                  <?php
                    //var_dump($lesson_image);
                    if($lesson_image){
                      echo "
                        <img src='../../../$lesson_image' alt='Lesson Image'>
                      ";
                    } else{
                      echo "
                        <h4 style='text-align: center; font-weight: var(--fw-400);'>
                          No Image
                        </h4>
                      ";
                    }
                  ?>

                  <br>
               
                  <div class="input-box">
                    <label for="lesson-image">Change Image:</label>
                    <input type="file" id="lesson-image" name="update-lesson-image" accept="image/*">
                  </div>
                </div>
                
                <div class="video">
                  <label class="label">Current Video:</label>

                  <?php
                    if($lesson_video){
                      echo "
                        <video controls>
                          <source src='../../../$lesson_video' type='video/mp4'>
                        </video>
                      ";
                    } else {
                      echo "
                        <h4 style='text-align: center; font-weight: var(--fw-400);'>No Video</h4>
                      ";
                    }
                  ?>

                  <br>

                  <div class="input-box">
                    <label for="lesson-video" class="label">Change Video:</label>
                    <input type="file" id="lesson-video" name="update-lesson-video" accept="video/*">
                  </div>
                </div>
              </div>

              <div class="input-box title">
                <label for="lesson-title" class="label">Lesson Title:</label>
                <input type="text" id="lesson-title" name="update-lesson-title" value="<?php echo $lesson_title ?>" required>
              </div>

              <div class="input-box content">
                <label for="lesson-content" class="label">Lesson Description:</label>
                <textarea id="lesson-content" name="update-lesson-content" required><?php echo $lesson_content ?></textarea>
              </div>

              <button type="submit" class="btn-primary">Save and Display</button>
            </form>

             <!-- delete lesson -->
             <form action="../../../src/teacher/deleteLesson.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this Lesson?');" class="delete-lesson-form">      
              <input type="hidden" name="course-id" value="<?php echo $get_course_id ?>">
              <input type="hidden" name="module-id" value="<?php echo $get_module_id ?>">
              <input type="hidden" name="lesson-id" value="<?php echo $lesson_id ?>">
              <button type="submit" class="delete-lesson">
                <img src="../../../assets/images/icons/icon-delete.svg" alt="Delete icon">
                Delete Lesson
              </button>
            </form>
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