<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (isset($_POST['userId']) && isset($_POST['temperature']) && isset($_POST['bloodPressure']) && isset($_POST['bloodGlucose']) && isset($_POST['cholesterol']) && isset($_POST['waistCircumference']) && isset($_POST['weight']) && isset($_POST['height']) && isset($_POST['date'])) {

        // Retrieve form data
        $userId = $_POST['userId'];
        $temperature = $_POST['temperature'];
        $bloodPressure = $_POST['bloodPressure'];
        $bloodGlucose = $_POST['bloodGlucose'];
        $cholesterol = $_POST['cholesterol'];
        $waistCircumference = $_POST['waistCircumference'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $date = $_POST['date'];

        // Calculate BMI
        $bmi = $weight / (($height / 100) * ($height / 100));

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'health');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO health_data (user_id, temperature, blood_pressure, blood_glucose, cholesterol, waist_circumference, weight, height, date, bmi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssddss", $userId, $temperature, $bloodPressure, $bloodGlucose, $cholesterol, $waistCircumference, $weight, $height, $date, $bmi);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "Form submitted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required!";
    }
} else {
    echo "Form not submitted!";
}
?>
