<?php
  include '../../db/connect.php';
  session_start();

  if(!isset($_SESSION['user-id'])){
    die("Access denied. Please log in.");
  }

  // profile update message
  $session_messages = [
    'profile-update-success',
    'profile-update-failed',
    'profile-update-image-failed'
  ];

  foreach($session_messages as $key){
    if(isset($_SESSION[$key])) {
      echo "
        <script>
          window.onload = () => {
            alert(`{$_SESSION[$key]}`);
          }
        </script>
      ";
      unset($_SESSION[$key]);
    }
  }


  $user_id = $_SESSION['user-id'];
  $profile_picture = null;
  $profile_name = null;
  $profile_email= null;
  $profile_role = null;

  $sql = "select * from user_tb where user_id='$user_id'";
  $container = mysqli_query($conn, $sql);

  if(mysqli_num_rows($container) > 0){
    $container = mysqli_fetch_array($container);
    $profile_picture = $container['picture'] ?? 'assets/images/no-picture.jpg';
    $profile_name = $container['name'];
    $profile_email= $container['email'];
    $profile_role = $container['role'];
    $profile_created = date("F j, Y", strtotime($container['created_at']));
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kitchenomachia Academy</title>
  <link rel="stylesheet" href="../../assets/styles/student/profile.css">
</head>
<body>
  <header class="navbar">
    <section class="container-xl wrapper">
      <article id="navbar-burger">
        <span></span>
        <span></span>
        <span></span>
      </article>

      <article class="logo">
        <img src="../../assets/images/logo/logo.png" alt="logo">
      </article>

      <nav class="nav">
        <a href="./dashboard.php">Dashboard</a>
        <a href="./course/myCourse.php">My Courses</a>
        <a class="active">Profile</a>
        <a href="../../src/auth/logout.php">Logout</a>
      </nav>
    </section>
  </header>


  <section class="container-sm">
    <div class="wrapper">
      <article class="header">
        <h2>My Profile</h2>
        <img src="../../<?php echo $profile_picture; ?>" alt="profile-picture" class="profile-picture">
      </article>

      <article class="profile-info">
        <div class="info">
          <h4>Name:</h4>
          <p>
            <?php echo $profile_name; ?>
          </p>
        </div>
        <div class="info">
          <h4>Email:</h4>
          <p>
            <?php echo $profile_email; ?>
          </p>
        </div>
        <div class="info">
          <h4>Role:</h4>
          <p>
            <?php echo $profile_role; ?>
          </p>
        </div>
        <div class="info">
          <h4>Joined at:</h4>
          <p>
            <?php echo $profile_created; ?>
          </p>
        </div>
      </article>

      <article class="edit-profile-form">
        <h3>Edit Profile</h3>
        <form action="../../src/student/updateProfile.php" method="post" enctype="multipart/form-data">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo $profile_name; ?>" required>

          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo $profile_email; ?>" required>

          <label for="picture">Upload Profile Picture</label>
          <input type="file" id="picture" name="picture" accept="image/*">

          <button type="submit" class="btn-primary">
            Update Profile
          </button>
        </form>
      </article>
    </div>
  </section>


  <script src="../../scripts/utils/navbar.js"></script>
</body>
</html>