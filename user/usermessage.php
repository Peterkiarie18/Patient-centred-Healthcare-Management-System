<?php
session_start(); // Start the session

include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: userlogin.php'); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Messaging Dashboard</title>
    <link rel="stylesheet" href="../css/dmstyles1.css"> <!-- Link to your CSS file -->
    <style>
        .user-info {
        text-align: right;
        margin-bottom: 20px;
        background-color: #3498db; /* Blue background color */
        color: #fff; /* Text color */
        padding: 8px 15px; /* Padding to create space around the text */
        border-radius: 5px; /* Rounded corners to create a bubbly effect */
        display: inline-block; /* Ensures the container wraps around the content */
    }
    .unread-button {
    background-color: red;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

/* Define styles for the "Read" button */
.read-button {
    background-color: green;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

    </style>>
</head>
<body>
    <div class="container">
        <div class="user-info">
            <?php
            // Check if user is logged in
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                // Retrieve the name of the currently logged-in user
                $sql = "SELECT username FROM users WHERE user_id = $userId";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // Display the user's name and an icon
                    echo '<i class="fas fa-user"></i> ' . $row['username'];
                }
            }
            ?>
        </div>
        <h2>User Messaging Dashboard</h2>
        
        <!-- Form to send message to doctor -->
        <form action="user_message.php" method="post" class="message-form">
            <textarea name="message" placeholder="Type your message"></textarea>
            <input type="submit" name="submit" value="Send">
        </form>
        
        <!-- Display sent and received messages -->
        <div class="message-container">
            <h3>Sent Messages</h3>
            <?php
            // Include config file
            include 'config.php';

            // Fetch sent messages from database for the logged-in user
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM messages WHERE sender_id = $user_id";
            $result = mysqli_query($conn, $sql);

            // Display sent messages
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='message sent'>" . $row['message'] . "<br>";
                echo "<strong>Time: </strong>" . $row['timestamp'] . "</div>";
            }
            ?>
        </div>
        
      <div class="message-container">
    <h3>Received Messages</h3>
    <?php
    // Fetch received messages from the database for the logged-in user
    $sql = "SELECT * FROM messages WHERE receiver_id = $user_id ORDER BY messages.timestamp DESC";
    $result = mysqli_query($conn, $sql);

    // Display received messages
    while ($row = mysqli_fetch_assoc($result)) {
        // Determine the button color based on the read status
        $buttonColor = ($row['is_read'] == 0) ? "red" : "green";
        $buttonText = ($row['is_read'] == 0) ? "Mark as Read" : "Read";

        echo "<div class='message received'>" . $row['message'] . "<br>";
        echo "<strong>Time: </strong>" . $row['timestamp'] . "<br>";

        // Add a button to mark the message as read
        echo "<button type='button' class='message-button' style='background-color: $buttonColor;' onclick='markAsRead(" . $row['id'] . ")'>$buttonText</button>";

        echo "</div>";
    }
    ?>
</div>

<script>
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


    </div>
</body>
</html> 