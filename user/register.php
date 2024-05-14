<?php

include 'config.php';

if(isset($_POST['submit'])){
   $uname = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $gender = mysqli_real_escape_string($conn, $_POST['gender']);
   $dob   = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $mobile = mysqli_real_escape_string($conn, $_POST['phone_number']);

   // File upload
   $profilePicture = '';
   if(isset($_FILES['profile_picture']['tmp_name']) && !empty($_FILES['profile_picture']['tmp_name'])) {
       $targetDir = "../user/profiles/"; // Adjusted target directory
       $fileName = basename($_FILES['profile_picture']['name']);
       $targetFile = $targetDir . $fileName;
       if(move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
           $profilePicture = 'profiles/' . $fileName; // Adding 'profiles/' prefix
       } else {
           $message[] = "Failed to upload profile picture.";
       }
   }

   $select = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$uname'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'User already exists!';
   }else{
      mysqli_query($conn, "INSERT INTO `users`(username, password, gender, date_of_birth, email, phone_number, picture) VALUES('$uname', '$pass', '$gender', '$dob', '$email', '$mobile', '$profilePicture')") or die('query failed');
      $message[] = 'Registered successfully!';
      header('location:userlogin.php');
   }

}

?> 

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/rstyle.css">
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
   <form action="" method="post" enctype="multipart/form-data">
      <h3>Register Now</h3>

      <input type="text" name="username" required placeholder="Name" class="box">
      <label for="gender">Gender:</label>
      <input class="gender-input" type="radio" id="male" name="gender" value="male" required>
      <label class="gender-label" for="male">Male</label>
      <input class="gender-input" type="radio" id="female" name="gender" value="female" required>
      <label class="gender-label" for="female">Female</label>
      <input type="date" name="date_of_birth" class="box">
      <input type="text" name="email" required placeholder="Email" class="box">
      <input type="text" name="phone_number" required placeholder="Mobile Number" class="box">
      <input type="password" name="password" required placeholder="Enter Password" class="box">
      <input type="password" name="cpassword" required placeholder="Confirm Password" class="box">
      <h1>Upload your image</h1>
      <input type="file" name="profile_picture" accept="image/*">
      <input type="submit" name="submit" class="btn" value="Register Now">
      <p>Already have an account? <a href="userlogin.php">Login Now</a></p>
   </form>
</div>

</body>
</html>
