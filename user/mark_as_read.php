<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: userlogin.php');
    exit();
}

// Include config file
include 'config.php';

// Check if message ID is set
if (isset($_POST['message_id'])) {
    // Sanitize message ID
    $message_id = mysqli_real_escape_string($conn, $_POST['message_id']);

    // Update the is_read column for the specified message ID
    $sql = "UPDATE messages SET is_read = 1 WHERE id = $message_id";
    if (mysqli_query($conn, $sql)) {
        // Redirect back to the messaging dashboard
        header('Location: usersms.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If message ID is not set, redirect to an error page
    header('Location: error.php');
    exit();
}
?>
