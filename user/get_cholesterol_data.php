<?php
// Include your database connection configuration file
include 'config.php';

// Start session to retrieve logged-in user's ID
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    // SQL query to fetch cholesterol data for the logged-in user
    $sql = "SELECT date, cholesterol FROM health_data WHERE user_id = $userId ORDER BY date";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Initialize an array to store cholesterol data
        $cholesterolData = array();
        while ($row = $result->fetch_assoc()) {
            // Add each data point to the array
            $cholesterolData[] = $row;
        }
        // Encode the array in JSON format and return it
        echo json_encode($cholesterolData);
    } else {
        // If no data is available, return an empty array
        echo json_encode(array());
    }
} else {
    // If user is not logged in, return an error message
    echo json_encode(array('error' => 'User not logged in'));
}
?>
