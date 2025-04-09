<?php
  require '../environment/php';

  $host = $db_host;
  $username = $db_username; 
  $password = $db_password;        
  $dbname = $db_name;

  $conn = new mysqli($host, $username, $password, $dbname);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
?>
