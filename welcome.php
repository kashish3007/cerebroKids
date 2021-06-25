<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
   <title>Welcome - <?php echo $_SESSION['username'] ?></title>
</head>
<body>
   <?php require 'partials/_nav.php' ?>
   <center> 
   <h3>Welcome login successful !</h3> 
   </center> 
</body>
</html>