
<?php
 include 'config.php';
session_start();
$user_id = $_SESSION['user_id']; 

if(!isset($user_id)){
   header('location:userlogin.php');
}; 
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
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users's Dashboard</title>
<link rel="stylesheet" href="../css/profile.css">
<style>
.dropbtn {
  background-color: #04AA6D;
  color: white;
 padding: 10px 20px;
  font-size: 16px;
  border: none;
  position: fixed;
  top: 10px;
  right: 160px;
  border-radius: 5px;
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



.notification-icon {
    position: fixed; /* Change to fixed to position relative to the viewport */
    top: 15px; /* Adjust the distance from the top */
    right: 120px; /* Adjust the distance from the right */
    display: inline-block;
    width: 30px; /* Adjust the width as needed */
    z-index: 9999; /* Ensure it appears above other content */
}

.notification-icon img {
    width: 100%;
    height: auto;
}

.notification-count {
    position: absolute;
    top: -5px; /* Adjust if needed */
    right: -5px; /* Adjust if needed */
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 3px 6px;
    font-size: 12px;
}

.sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    top: 0;
    left: -250px;
    background-color: #ADD8E6; /* Light blue color */
    padding-top: 60px; /* Adjust based on your design */
    transition: 0.3s;
}

.sidebar a {
    padding: 10px 15px;
    text-decoration: none;
    font-size: 18px;
    color: #000; /* Text color */
    display: block;
    transition: 0.3s;
}

.sidebar a:hover {
    background-color: #87CEEB; /* Light blue color on hover */
}

.sidebar.active {
    left: 0;
}

.content {
    padding: 20px;
    transition: margin-left 0.3s; /* Transition for margin-left property */
}

/* Button to open the sidebar */
.openbtn {
    font-size: 10px;
    cursor: pointer;
    background-color: #ADD8E6; /* Light blue color */
    color: #000; /* Text color */
    border: none;
    position: fixed;
    top: 10px;
    left: 10px;
    padding: 10px 15px;
    z-index: 9999;
}

.openbtn:hover {
    background-color: #87CEEB; /* Light blue color on hover */
}
.logout-container {
    position: fixed;
    top: 10px;
    right: 10px;
}

.logout-button {
    background-color: #f44336; /* Red color */
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.logout-button:hover {
    background-color: #571c1c; /* Darker red color on hover */
}
/* Overall styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.content {
    padding: 20px;
    margin: 0 auto
}

h2 {
    color: #007bff;


}

p {
    color: #666;
}

/* Sections styling */
#overview, #data, #linegraphs, #communication, #education {
    margin: 0 auto; /* This centers the element horizontally */
    margin-bottom: 30px;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 80%; /* You can adjust the width as needed */
    max-width: 800px; /* Optionally, set a maximum width for the element */
}


#overview h2, #data h2, #linegraphs h2, #communication h2, #education h2 
{
    color: #007bff;
}

#overview p, #data p, #linegraphs p, #communication p, #education p 
{
    color: #333;
}

/* Link styling */
a 
{
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}


</style>
</head>
<body>
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
</div>   
<div class="notification-icon">
        <img src="../img/bell2.png"> <!-- Replace 'bell-icon.png' with your bell icon image -->
        <?php
        // Include your database connection configuration file
        include 'config.php';

        // Fetch the number of unread messages for the logged-in user from the database
        $sql = "SELECT COUNT(*) AS unread_count FROM messages WHERE receiver_id = $user_id AND is_read = 0";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $unreadCount = $row['unread_count'];

        // Display the notification count if there are unread messages
        if ($unreadCount > 0) {
            echo "<span class='notification-count'>$unreadCount</span>";
        }
        ?>
    </div>
<div class="logout-container">
    <form action="Ulogout.php" method="post">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</div>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a href="userdashboard.php">• HOMEPAGE</a>
    <a href="#" onclick="openPage('userview.php')">• RECORDS</a>  
    <a href="linegraphs.php">• VIEW GRAPHS</a>
    <a href="#" onclick="openPage('usermessage.php')">• MESSAGES</a>
    <a href="#" onclick="openPage('NCD.php')">• EDUCATIONAL RESOURCES</a>
    
</div>

<!-- Button to open the sidebar -->
<button class="openbtn" onclick="toggleSidebar()">☰</button>

<!-- Content -->
<div class="content" id="content">
    
    
    <section id="overview">
        <h2>Welcome To Your Health Overview</h2>
        <p>Welcome to our patient system! Here, you can view your health data, including temperature, blood glucose, blood pressure, cholesterol, waist circumference, weight, height, and BMI. You can also visualize your data in line graphs and securely communicate with your doctor. Additionally, we offer educational materials on non-communicable diseases (NCDs) to help you make informed decisions about your health.</p>
    </section>
    
    <section id="data">
        <h2>Your Health Data</h2>
        <center><img src="../img/data.png"></center>
        <p>View your health data in a comprehensive table format. Monitor your progress and track changes over time.</p>
    </section>
    
    <section id="linegraphs">
        <h2>Line Graphs</h2>
        <center><img src="../img/linegraph.png"></center>
        <p>Visualize your health data using interactive line graphs. Identify trends and patterns to better understand your health status.</p>
    </section>
    
    <section id="communication">
        <h2>Communicate with Your Doctor</h2>
        <center><img src="../img/chat.png"></center>
        <p>Securely communicate with your doctor using our messaging feature. Discuss your health concerns and receive personalized advice.</p>
    </section>
    
    <section id="education">
        <h2>Educational Materials on NCDs</h2>
        <center><img src="../img/resources.jpeg"></center>
        <p>Learn more about non-communicable diseases (NCDs) and prevention strategies. Empower yourself to make healthier lifestyle choices and reduce your risk of developing chronic health conditions.</p>
    </section>
</div>


<script>
function toggleSidebar() {
    var sidebar = document.getElementById("sidebar");
    var content = document.getElementById("content");
    sidebar.classList.toggle('active');
    if (sidebar.classList.contains('active')) {
        content.style.marginLeft = "250px"; // Adjust based on sidebar width
    } else {
        content.style.marginLeft = "0";
    }
}



function openPage(page) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Check if the requested page is for graphs
            if (page === 'linegraphs.php') {
                // Load graphs into the graphs-container div
                document.getElementById("graphs-container").innerHTML = this.responseText;
            } else {
                // Load other content normally
                document.getElementById("content").innerHTML = this.responseText;
            }
        }
    };
    xhttp.open("GET", page, true);
    xhttp.send();
}

function markAsRead(messageId) {
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Specify the POST request details
    xhr.open('POST', 'mark_as_read.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Define the callback function when the request completes
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Update the button color and text
            var button = document.querySelector('[onclick="markAsRead(' + messageId + ')"]');
            button.style.backgroundColor = 'green';
            button.innerText = 'Read';
        }
    };

    // Send the request with the message ID as data
    xhr.send('message_id=' + messageId);
}






</script>



</body>
</html>
