<?php
// Start session and include config file
session_start();
include 'config.php';

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get message and receiver ID from form
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $receiver_id = mysqli_real_escape_string($conn, $_POST['user_id']); // For doctor dashboard, this is already set

    // Get sender ID from session
    $sender_id = null; // For user dashboard, this is already set

    // Prepare and execute SQL statement to insert message into database
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();
    $stmt->close();

    // Redirect all users to messaging.php
    echo "<script>alert('Message sent successfully');</script>";
    exit(); // Stop script execution after redirection
}
?>
