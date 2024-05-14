<?php


// Doctor login process
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $uname = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $select = mysqli_query($conn, "SELECT * FROM `doctor` WHERE uid = '$uid' AND username = '$uname' AND password = '$pass'");
    
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['doctor_id'] = $row['doctor_id']; // Set doctor_id in session
        header('location: doctordashboard.php');
        exit();
    } else {
        $message[] = 'incorrect credentials!';
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
      <input type="name" name="uid" required placeholder="Unique Identification Number (UID)" class="box">
      <input type="name" name="username" required placeholder=" Name" class="box">
      <input type="password" name="password" required placeholder=" Password" class="box">
      <input type="submit" name="submit" class="btn" value="login now">
      <p><a href="../index.html">HOMEPAGE</a></p>
   </form>

</div>

</body>
</html>