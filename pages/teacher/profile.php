<?php
include '../../db/connect.php';
session_start();

if(!isset($_SESSION['user-id'])){
  die("Access denied. Please log in.");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../assets/styles/teacher/dashboard.css">
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
        <img src="../../assets/images/logo/logo-w-text.png" alt="logo">
      </article>

      <nav class="nav">
        <a href="./dashboard.php">Dashboard</a>
        <a href="./course/myCourse.php">My Courses</a>
        <a class="active">Profile</a>
        <a href="../../src/auth/logout.php">Logout</a>
      </nav>
    </section>
  </header>





  <script src="../../scripts/utils/navbar.js"></script>
</body>
</html>