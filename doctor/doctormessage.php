<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Messaging Dashboard</title>
    <link rel="stylesheet" href="../css/dmstyles1.css"> <!-- Link to your CSS file -->
    <style>
        /* Define styles for the "Mark as Read" button */
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Doctor Messaging Dashboard</h2>
        
        <!-- Form to send message to user -->
        <form action="send_message.php" method="post" class="message-form">
            <select name="user_id">
                <?php
                // Include config file
                include 'config.php';

                // Fetch users from database
                $sql = "SELECT user_id, username FROM users";
                $result = $conn->query($sql);

                // Display users in dropdown menu
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['user_id'] . "'>" . $row['username'] . "</option>";
                }
                ?>
            </select>
            <textarea name="message" placeholder="Type your message"></textarea>
            <input type="submit" name="submit" value="Send">
        </form>
        
        <!-- Display sent and received messages -->
        <div class="message-container">
            <h3>Sent Messages</h3>
            <?php
            // Fetch sent messages from database
            $doctor_id = 100; // Assuming doctor_id is always 100
            $sql = "SELECT m.*, u.username AS recipient_name FROM messages m 
                    INNER JOIN users u ON m.receiver_id = u.user_id 
                    WHERE sender_id IS NULL";
            $result = mysqli_query($conn, $sql);

            // Display sent messages
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='message sent'>";
                echo "<strong>To: </strong>" . $row['recipient_name'] . "<br>";
                echo "<strong>Message: </strong>" . $row['message'] . "<br>";
                echo "<strong>Time: </strong>" . $row['timestamp'] . "</div>";
            }
            ?>
        </div>
        
        <div class="message-container">
            <h3>Received Messages</h3>
             <?php
            // Fetch received messages from database
            $sql = "SELECT messages.*, users.username AS sender FROM messages JOIN users ON messages.sender_id = users.user_id WHERE receiver_id IS NULL ORDER BY messages.timestamp DESC";
            $result = mysqli_query($conn, $sql);

            // Display received messages
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='message received'>";
                echo "<strong>Sender: </strong>" . $row['sender'] . "<br>";
                echo "<strong>Message: </strong>" . $row['message'] . "<br>";
                echo "<strong>Time: </strong>" . $row['timestamp'] . "<br>"; // Display timestamp
                 $buttonColor = ($row['is_read'] == 0) ? "red" : "green";
                 $buttonText = ($row['is_read'] == 0) ? "Mark as Read" : "Read";
                // Add "Mark as Read" button
                echo "<form action='mark_as_read.php' method='post'>";
                echo "<input type='hidden' name='message_id' value='" . $row['id'] . "'>";
                echo "<button type='button' class='message-button' style='background-color: $buttonColor;' onclick='markAsRead(" . $row['id'] . ")'>$buttonText</button>";

                echo "</div>"; // Close message div
            }
            ?>
        </div>
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
</body>
</html>
