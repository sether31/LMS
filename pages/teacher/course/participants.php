<?php
include '../../../db/connect.php';
session_start();

if(!isset($_SESSION['user-id'])){
  die("Access denied. Please log in.");
}

$user_id = $_SESSION['user-id'];
$get_course_id = $_GET['courseId'];

?>