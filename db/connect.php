<?php
  $host = "localhost";
  $username = "root";
  $password = "";        
  $dbname = "kitchenomachia_academydb";

  $conn = mysqli_connect($host, $username, $password, $dbname);

  if($conn === false){
    die("Error: " . mysqli_connect_error());
  }
?>
