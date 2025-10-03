<?php
  $host = "localhost";
  $username = "root";
  $password = "";        
  $dbname = "lms_db";

  $conn = mysqli_connect($host, $username, $password, $dbname);

  if($conn === false){
    die("Error: " . mysqli_connect_error());
  }
?>
