<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  $sql = "select count(*) as total_students from user_tb where role = 'student'";
  $container = mysqli_query($conn, $sql);
  $container = mysqli_fetch_array($container);
  $total_students = $container['total_students'];

  $sql2 = "select count(*) as total_courses from course_tb where is_delete = 0";
  $container2 = mysqli_query($conn, $sql2);
  $container2 = mysqli_fetch_array($container2);
  $total_courses = $container2['total_courses'];

  $sql3 = "select count(*) as total_modules from module_tb where is_delete = 0";
  $container3 = mysqli_query($conn, $sql3);
  $container3 = mysqli_fetch_array($container3);
  $total_modules = $container3['total_modules'];

  $sql4 = "select count(*) as total_lessons from lesson_tb where is_delete = 0";
  $container = mysqli_query($conn, $sql4);
  $container = mysqli_fetch_array($container);
  $total_lessons = $container['total_lessons'];

  // CHART
  $sql_courses_modules = "
    select
      course_tb.title, 
      count(module_tb.module_id) as total_modules, 
      count(lesson_tb.lesson_id) as total_lessons
    FROM 
      course_tb
    left join 
      module_tb on course_tb.course_id = module_tb.course_id
    left join 
      lesson_tb on module_tb.module_id = lesson_tb.module_id
    group by
      course_tb.course_id
  ";

  $result_courses_modules = mysqli_query($conn, $sql_courses_modules);

  if(!$result_courses_modules){
    die('Error executing query for courses modules: ' . mysqli_error($conn));
  }

  $courses_data = [];
  while($row = mysqli_fetch_array($result_courses_modules)){
    $courses_data[] = [
      'course_name' => $row['title'],
      'modules' => $row['total_modules'],
      'lessons' => $row['total_lessons']
    ];
  }

  echo "<script> 
    const coursesData = " . json_encode($courses_data) . ";
  </script>";
?>
