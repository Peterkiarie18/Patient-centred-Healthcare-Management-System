  <?php
  session_start();
  include 'config.php'; // Include your database connection configuration file
  $user_id = $_SESSION['user_id']; 
  // Fetch user information from the database (replace placeholders with actual column names)
  $sql = "SELECT * FROM users WHERE user_id = $user_id"; // Assuming user_id is stored in session
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $username = $row['username'];
      $gender = $row['gender'];
      $dateOfBirth = $row['date_of_birth'];
      $email = $row['email'];
      $phoneNumber = $row['phone_number'];
      $profilePic = $row['picture'];
  } else {
      // Handle case when user profile is not found
      $username = "User Not Found";
      $gender = "Unknown";
      $dateOfBirth = "Unknown";
      $email = "Unknown";
      $phoneNumber = "Unknown";
      $profilePic = "default_profile_pic.jpg"; // Provide a default profile picture
  }
  $stmt->close();
  $conn->close();
  ?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/profile.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  position: fixed;
  top: 0px;
  right: 200px;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
   display: none;
  position: fixed;
  top: 60px;
  right: 20px;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>
</head>
<body style="background-color:white;">

<div class="dropdown">
  <button class="dropbtn">Profile</button>
  <div class="dropdown-content">
    <div class="profile-content">
    <img src="<?php echo $profilePic; ?>" alt="<?php echo $username; ?>" style="width:100%">
  <h1><?php echo $username; ?></h1>
  <p class="title"></p>
  <p>Gender: <?php echo $gender; ?></p>
  <?php
    // Calculate age based on date of birth
    $dob = new DateTime($dateOfBirth);
    $now = new DateTime();
    $age = $now->diff($dob)->y;
  ?>
  <p>Age: <?php echo $age; ?></p>
  <p>Mobile: <?php echo $phoneNumber; ?></p>
  <p>Email: <?php echo $email; ?></p>

  <p><button></button></p>
  </div>
</div>

</body>
</html>
