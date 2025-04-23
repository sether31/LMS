<?php
include '../../db/connect.php';
session_start();

if (!isset($_SESSION['user-id'])) {
  die("Access denied. Please log in.");
}

?>