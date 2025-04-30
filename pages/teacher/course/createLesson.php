<?php
  include '../../../db/connect.php';
  session_start();
  if (!isset($_SESSION['user-id'])) {
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
  <title>Document</title>
  <link rel="stylesheet" href="../../../assets/styles/teacher/course/createLesson.css">
</head>
<body>
  <section class="container-sm">
    <fieldset>
      <legend>
        <h3>Create Lesson</h3>
      </legend>

      <form method="POST" action="../../../src/teacher/createLesson.php?courseId=<?php echo $get_course_id?>" enctype="multipart/form-data">
        
        <input type="hidden" name="module-id" value="<?php echo $get_module_id; ?>">
        
        <div class="image">
          <label for="lesson-image">Upload Image (10MB):</label>
          <br>
          <input type="file" id="lesson-image" name="lesson-image" accept="image/*">
        </div>

        <div class="video">
          <label for="lesson-video">Upload Video (100MB):</label>
          <br>
          <input type="file" id="lesson-video" name="lesson-video" accept="video/*">
        </div>

        <div class="input-box title">
          <label for="lesson-title">Lesson Title:</label>
          <input type="text" id="lesson-title" name="lesson-title" required>
        </div>

        <div class="input-box content">
          <label for="lesson-content">Lesson Content:</label>
          <textarea id="lesson-content" name="lesson-content" required></textarea>
        </div>

        <button type="submit" class="btn-primary">
          Create Lesson
        </button>
      </form>
    </fieldset>
  </section>
</body>
</html>