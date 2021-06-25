<?php
    $login = false;
    $showError = false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      include 'partials/_dbconnect.php';
      $username = $_POST["mail"];
      $password = $_POST["pass"];
      $sql = "Select * from `users` where username = '$username' AND password = '$password'";
      $result = mysqli_query($conn,$sql);
      $num = mysqli_num_rows($result);
      if($num == 1){
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: welcome.php");
      }
      else{
        $showError = "Invalid Credentials";
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
   <title>Login</title>
</head>
<body>
  <?php require 'partials/_nav.php' ?> 
  <?php
  if($login){
    echo '<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Well done!</h4>
    <p>Logged in successfully</p>
    </div>';
  }
  if($showError){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Sorry!</strong>'.$showError.'
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
  ?>
  <div class="container my-4">
  <h1 class="text-center">Login to our website</h1>
  <form action="login.php" method = "POST" enctype = "multipart/form-data" >
    <div class="mb-3">
    <label for="mail" class="form-label">Username</label>
    <input type="email" class="form-control" id="mail" name="mail" aria-describedby="emailHelp" required>
    <div id="emailHelp" class="form-text">We'll never share your email/username with anyone else.</div>
    </div>
    <div class="mb-3">
    <label for="pass" class="form-label">Password</label>
    <input type="password" class="form-control" id="pass" name="pass" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  </div>
</body>
</html>