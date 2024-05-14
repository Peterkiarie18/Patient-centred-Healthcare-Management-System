<?php
// Start session and include config file
session_start();
include 'config.php';

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get message from form
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Set receiver ID
    $receiver_id = null;

    // Set sender ID to null
    $sender_id = $_SESSION['user_id'];

    // Prepare and execute SQL statement to insert message into database
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();
    $stmt->close();

    // Send response to JavaScript to display popup
    echo "<script>alert('Message sent successfully');</script>";
}

?>
