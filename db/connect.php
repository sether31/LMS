<?php
  require_once(__DIR__ . '/../env.php');

  $host = $db_host;
  $username = $db_username;
  $password = $db_password;        
  $dbname = $db_name;

  $conn = new mysqli($host, $username, $password, $dbname);

  if ($conn === false) {
      die("Connection failed: " . mysqli_connect_error());
  }
?>
