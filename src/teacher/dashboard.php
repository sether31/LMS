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

  // publish unpublish course
  $sql2 = "select count(*) as total_publish_courses from course_tb where is_delete = 0 and status = 'publish'";
  $total_publish_courses = mysqli_query($conn, $sql2);
  $total_publish_courses = mysqli_fetch_array($total_publish_courses);
  $total_publish_courses = $total_publish_courses['total_publish_courses'];

  $sql3 = "select count(*) as total_unpublish_courses from course_tb where is_delete = 0 and status = 'unpublish'";
  $total_unpublish_courses = mysqli_query($conn, $sql3);
  $total_unpublish_courses = mysqli_fetch_array($total_unpublish_courses);
  $total_unpublish_courses = $total_unpublish_courses['total_unpublish_courses'];

  // active inactive module
  $sql4 = "
    select count(*) as total_active_modules 
    from module_tb 
    inner join course_tb ON module_tb.course_id = course_tb.course_id 
    where module_tb.is_delete = 0 
      and course_tb.is_delete = 0
      and module_tb.status = 'active'
      and course_tb.status = 'publish'
  ";

  $total_active_modules = mysqli_query($conn, $sql4);
  $total_active_modules = mysqli_fetch_array($total_active_modules);
  $total_active_modules = $total_active_modules['total_active_modules'];

  $sql5 = "
    select count(*) as total_inactive_modules 
    from module_tb 
    inner join course_tb ON module_tb.course_id = course_tb.course_id 
    where module_tb.is_delete = 0 
      and course_tb.is_delete = 0
      and module_tb.status = 'inactive' 
      and course_tb.status = 'publish' 
  ";
  $total_inactive_modules = mysqli_query($conn, $sql5);
  $total_inactive_modules = mysqli_fetch_array($total_inactive_modules);
  $total_inactive_modules = $total_inactive_modules['total_inactive_modules'];

  // active lesson and inactive lesson
  $sql6 = "
    select count(*) as total_active_lessons
    from lesson_tb
    inner join module_tb ON lesson_tb.module_id = module_tb.module_id
    inner join course_tb ON module_tb.course_id = course_tb.course_id
    where lesson_tb.is_delete = 0
      and module_tb.is_delete = 0 
      and course_tb.is_delete = 0
      and module_tb.status = 'active'
      and course_tb.status = 'publish' 
  ";

  $total_active_lessons = mysqli_query($conn, $sql6);
  $total_active_lessons = mysqli_fetch_array($total_active_lessons);
  $total_active_lessons = $total_active_lessons['total_active_lessons'];

  // active lesson and inactive lesson
  $sql6 = "
    select count(*) as total_inactive_lessons
    from lesson_tb
    inner join module_tb ON lesson_tb.module_id = module_tb.module_id
    inner join course_tb ON module_tb.course_id = course_tb.course_id
    where lesson_tb.is_delete = 0
      and module_tb.is_delete = 0 
      and course_tb.is_delete = 0
      and module_tb.status = 'inactive'
      and course_tb.status = 'publish' 
  ";
  $total_inactive_lessons = mysqli_query($conn, $sql6);
  $total_inactive_lessons = mysqli_fetch_array($total_inactive_lessons);
  $total_inactive_lessons = $total_inactive_lessons['total_inactive_lessons'];

  // CHART
  $sql_courses_modules = "
    select
      course_tb.title, 
      COUNT(DISTINCT module_tb.module_id) as total_modules, 
      COUNT(DISTINCT lesson_tb.lesson_id) as total_lessons
    from 
      course_tb
    left join 
      module_tb on course_tb.course_id = module_tb.course_id
    left join 
      lesson_tb on module_tb.module_id = lesson_tb.module_id
    where course_tb.status = 'publish' and module_tb.status = 'active' and course_tb.is_delete = 0 and module_tb.is_delete = 0 and lesson_tb.is_delete = 0
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