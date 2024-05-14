<?php
// Include your database connection configuration file
include 'config.php';

// Start session to retrieve logged-in user's ID
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    // SQL query to fetch temperature data for the logged-in user
    $sql = "SELECT date, temperature FROM health_data WHERE user_id = $userId ORDER BY date";
    $result = $conn->query($sql);
    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Append date and temperature to data array
            $data[] = array(
                'date' => $row['date'],
                'temperature' => $row['temperature']
            );
        }
    } else {
        // If no data available, return empty array
        $data = array();
    }

    // Return data as JSON
    echo json_encode($data);
} else {
    // If user is not logged in, return empty array
    echo json_encode(array());
}
?>
