<?php
session_start(); // Start the session

include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['doctor_id'])) {
    header('Location: doctorlogin.php'); // Redirect to login page if not logged in
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor's Dashboard</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}
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
    background-color: #d32f2f; /* Darker red color on hover */
}
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

</style>
</head>
<body>
<div class="notification-icon">
        <img src="../img/bell2.png"> <!-- Replace 'bell-icon.png' with your bell icon image -->
        <?php
        // Include your database connection configuration file
        include 'config.php';

        // Fetch the number of unread messages for the logged-in user from the database
        $sql = "SELECT COUNT(*) AS unread_count FROM messages WHERE receiver_id is NULL AND is_read = 0";
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
    <form action="Dlogout.php" method="post">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</div>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a href="#" onclick="openPage('form.php')">FORM</a>
    <a href="#" onclick="openPage('doctorview.php')">PATIENT DATA</a>
    <a href="#" onclick="openPage('doctormessage.php')">MESSAGES</a>
    
</div>

<!-- Button to open the sidebar -->
<button class="openbtn" onclick="toggleSidebar()">☰</button>

<!-- Content -->
<div class="content" id="content">
    <h2>Doctor Dashboard</h2>
    <section id="data">
        <h2>Health Data</h2>
        <center><img src="../img/data.png"></center>
        <p>Enter and view selected user's health data, including temperature, blood glucose, blood pressure, cholesterol, waist circumference, weight, height, and BMI. You can also visualize their data in tables and communicate with patients.<p>
    <p></p>
</div>

<section id="communication">
        <h2>Communicate with Your Doctor</h2>
        <center><img src="../img/chat.png"></center>
        <p> communicate with your patient using our messaging feature. Discuss their health concerns and receive personalized advice.</p>
    </section>

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
            document.getElementById("content").innerHTML = this.responseText;
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
