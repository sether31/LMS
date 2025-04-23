<?php
session_start();

session_unset();
session_destroy();

header("Location: ../../pages/authentication/login.php");
exit();
?>