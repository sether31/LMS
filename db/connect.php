<?php
  $host = "localhost";
  $username = "root";
  $password = "";        
  $dbname = "Kitchenomachia_Academydb";

  $conn = mysqli_connect($host, $username, $password, $dbname);

  if($conn === false){
    die("Error: " . mysqli_connect_error());
  }
?>
