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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/profile.css">

</head>
<body>



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

</body>
</html>
