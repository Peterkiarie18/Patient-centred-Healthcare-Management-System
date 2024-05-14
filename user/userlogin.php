<?php

include 'config.php';
session_start();

   if(isset($_POST['submit'])){

      $uname = mysqli_real_escape_string($conn, $_POST['username']);
      $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

      $select = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$uname' AND password = '$pass'") or die('query failed');

      if(mysqli_num_rows($select) > 0){
         $row = mysqli_fetch_assoc($select);
         $_SESSION['user_id'] = $row['user_id'];
         header('location:userdashboard.php');
      }else{
         $message[] = 'incorrect password or username!';
      }

   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/lstyle.css">

</head>
<body>
  

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
  


<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="name" name="username" required placeholder="enter username" class="box">
      <input type="password" name="password" required placeholder="enter password" class="box">
      <input type="submit" name="submit" class="btn" value="login now">
      <p>don't have an account? <a href="register.php">register now</a></p>

      <p><a href="../index.html">HOMEPAGE</a></p>
   </form>

</div>

</body>
</html>