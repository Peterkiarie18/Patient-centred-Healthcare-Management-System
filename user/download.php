<?php
// Include your database connection configuration file
include 'config.php';

// Start session to retrieve logged-in user's ID
session_start();

// Set CSV file name
$filename = "health_data.csv";

// Set headers for CSV file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open output stream
$output = fopen('php://output', 'w');

// Write CSV headers
fputcsv($output, array('Date', 'Temperature (°C)', 'Blood Pressure (mmHg)', 'Blood Glucose (mg/dL)', 'Cholesterol (mg/dL)', 'Waist Circumference (cm)', 'Weight (kg)', 'Height (cm)', 'BMI'));

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    // SQL query to fetch patient details for the logged-in user
    $sql = "SELECT * FROM health_data WHERE user_id = $userId ORDER BY date";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Loop through each row and write to CSV
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, array(
                $row['date'],
                $row['temperature'],
                $row['blood_pressure'],
                $row['blood_glucose'],
                $row['cholesterol'],
                $row['waist_circumference'],
                $row['weight'],
                $row['height'],
                $row['bmi']
            ));
        }
    }
}

// Close output stream
fclose($output);
?>
