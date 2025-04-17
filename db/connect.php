<?php
  require_once(__DIR__ . '/../env.php');

  $host = $db_host;
  $username = $db_username;
  $password = $db_password;        
  $dbname = $db_name;

  $conn = mysqli_connect($host, $username, $password, $dbname);

  if($conn === false){
    die("Error: " . mysqli_connect_error());
  }
?>
