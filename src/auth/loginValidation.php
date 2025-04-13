<?php
session_start(); 
require_once '../../db/connect.php';

if(isset($_SESSION['register-success'])){
  $message = $_SESSION['register-success'];
  echo "
    <script>
      window.onload = ()=>{
        alert('$message');
      };
    </script>
  ";
  unset($_SESSION['register-success']);
} 

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $email_input = $_POST['login-email'];
  $password_input = $_POST['login-password'];
  $role_input = $_POST['login-role'];

  // find the user
  $sql = "SELECT user_id, name, email, password, role FROM user_tb WHERE email = ? AND role = ?";
  $container = $conn->prepare($sql);

  if($container){
    $container->bind_param("ss", $email_input, $role_input);
    $container->execute();
    $container->store_result();

    if($container->num_rows > 0){
      $container->bind_result($user_id, $name, $email, $hashed_password, $role);
      $container->fetch();

      if(password_verify($password_input, $hashed_password)){
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = $role;

        if ($role === 'teacher') {
            header("Location: ../../pages/teacher/dashboard.php");
        } else {
            header("Location: ../../pages/student/dashboard.php");
        }
        exit();
      } else{
          $_SESSION['password-error'] = "Incorrect password!";
      } 
    } else{
        $_SESSION['login-error'] = "No account found for this email & role.";
    }
    $container->close(); 
  } else{
    echo "prepare failed: " . $conn->error; 
  }
  $conn->close();
}
?>
