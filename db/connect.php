<?php
  require_once(__DIR__ . '/../env.php');

  // $host = $db_host;
  // $username = $db_username;
  // $password = $db_password;        
  // $dbname = $db_name;

  $host = "localhost";
  $username = "root";
  $password = "";        
  $dbname = "Kitchenomachia-Academydb";

  $conn = mysqli_connect($host, $username, $password, $dbname);

  if($conn === false){
    die("Error: " . mysqli_connect_error());
  }
?>
