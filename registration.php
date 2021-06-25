<?php
    $showAlert = false;
    $showError = false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    $targetDir = "uploads/";
    $fileName = basename($_FILES["imgs"]["name"]);
    $targetFilePath = $targetDir.$fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    if(isset($_POST["submit"]) && !empty($_FILES["imgs"]["name"])) {
      $allowTypes = array('jpg','png','jpeg','gif','pdf','svg');
      if(in_array($fileType,$allowTypes)){
        if(move_upload_file($_FILES["imgs"]["tmp_name"],$targetFilePath)){
          $insert = $db->query("INSERT into `users` (media) VALUES ('$targetFilePath')");
          if(!$insert){
            $showError = "image upload failed,please upload again!";
          }
        }
      }
    }
    $username = $_POST["mail"] ?? "";
    $password = $_POST["pass"];
    $cpassword = $_POST["cpass"];
    $existSql = "SELECT * FROM `users` WHERE username = '$username';";
    $result = mysqli_query($conn,$existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0){
        $showError = "Username already exists";
    }
    else{
        if(($password == $cpassword)){
            $sql = "INSERT INTO `users` (`username`, `password`, `date`) VALUES ('$username', '$password', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            if($result){
                $showAlert = true ;
            }
            else{
                $showError = "Passwords do not match!";
            }
    }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
   <title>Register</title>
</head>
<body>
  <?php require 'partials/_nav.php' ?> 
  <?php
  if($showAlert){
    echo '<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Well done!</h4>
    <p>Registered successfully</p>
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
  <h1 class="text-center">Sign up to our website</h1>
  <form action="registration.php" method = "POST" enctype = "multipart/form-data" >
    <div class="mb-3">
    <label for="imgs" class="form-label">Upload a picture</label><br>
    <input type="file" id="imgs" name="imgs" required>
    </div>
    <div class="mb-3">
    <label for="mail" class="form-label">Username</label>
    <input type="email" class="form-control" id="mail" name="mail" aria-describedby="emailHelp" required>
    <div id="emailHelp" class="form-text">We'll never share your email/username with anyone else.</div>
    </div>
    <div class="mb-3">
    <label for="pass" class="form-label">Password</label>
    <input type="password" class="form-control" id="pass" name="pass" required>
    </div>
    <div class="mb-3">
    <label for="cpass" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="cpass" name="cpass" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  </div>
</body>
</html>