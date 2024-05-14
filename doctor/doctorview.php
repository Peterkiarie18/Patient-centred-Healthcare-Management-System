<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients' Health Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS (for user icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        /* Add custom styles here */
        .red-cell {
            background-color: #ffcccc; /* Light red */
        }
        .green-cell {
            background-color: #ccffcc; /* Light green */
        }
        .user-info {
            text-align: right;
            margin-bottom: 20px;
            background-color: #3498db; /* Blue background color */
            color: #fff; /* Text color */
            padding: 8px 15px; /* Padding to create space around the text */
            border-radius: 5px; /* Rounded corners to create a bubbly effect */
            display: inline-block; /* Ensures the container wraps around the content */
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Patients' Health Details</h1>
    <?php
    // Include your database connection configuration file
    include 'config.php';

    // SQL query to fetch all patients' details
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Iterate over each patient
        while ($row = $result->fetch_assoc()) {
            echo '<h3>' . $row['username'] . "</h3>";
            echo '<h3>' . $row['phone_number'] . "</h3>";
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Date</th>';
            echo '<th>Temperature (°C)</th>';
            echo '<th>Blood Pressure (mmHg)</th>';
            echo '<th>Blood Glucose (mg/dL)</th>';
            echo '<th>Cholesterol (mg/dL)</th>';
            echo '<th>Waist Circumference (cm)</th>';
            echo '<th>Weight (kg)</th>';
            echo '<th>Height (cm)</th>';
            echo '<th>BMI</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            // SQL query to fetch health data for the current patient
            $healthSql = "SELECT * FROM health_data WHERE user_id = {$row['user_id']} ORDER BY date";
            $healthResult = $conn->query($healthSql);
            if ($healthResult->num_rows > 0) {
                // Iterate over each health record
                while ($healthRow = $healthResult->fetch_assoc()) {
                    // Check if any data is in the unhealthy range
                    $unhealthy = false;
                    // Check each parameter and apply CSS class if it's unhealthy
                    // You need to adjust these conditions based on your specific health guidelines
                    if ($healthRow['temperature'] > 37.2 || $healthRow['temperature'] < 36.1 ||
                        $healthRow['blood_pressure'] > 130 || $healthRow['blood_pressure'] < 90 ||
                        $healthRow['blood_glucose'] > 126 ||
                        $healthRow['cholesterol'] > 240 ||
                        $healthRow['waist_circumference'] > 102 ||
                        $healthRow['bmi'] < 18.5 || $healthRow['bmi'] > 24.9) {
                        $unhealthy = true;
                    }
                    // Output table rows with patient details
                    echo "<tr>";
                    echo "<td>" . $healthRow['date'] . "</td>";
                    echo "<td class='" . ($unhealthy && $healthRow['temperature'] > 37.2 ? "red-cell" : "green-cell") . "'>" . $healthRow['temperature'] . "</td>";
                    echo "<td class='" . ($unhealthy && ($healthRow['blood_pressure'] > 130 || $healthRow['blood_pressure'] < 90) ? "red-cell" : "green-cell") . "'>" . $healthRow['blood_pressure'] . "</td>";
                    echo "<td class='" . ($unhealthy && $healthRow['blood_glucose'] > 126 ? "red-cell" : "green-cell") . "'>" . $healthRow['blood_glucose'] . "</td>";
                    echo "<td class='" . ($unhealthy && $healthRow['cholesterol'] > 240 ? "red-cell" : "green-cell") . "'>" . $healthRow['cholesterol'] . "</td>";
                    echo "<td class='" . ($unhealthy && $healthRow['waist_circumference'] > 102 ? "red-cell" : "green-cell") . "'>" . $healthRow['waist_circumference'] . "</td>";
                    echo "<td>" . $healthRow['weight'] . "</td>";
                    echo "<td>" . $healthRow['height'] . "</td>";
                    echo "<td class='" . ($unhealthy && ($healthRow['bmi'] < 18.5 || $healthRow['bmi'] > 24.9) ? "red-cell" : "green-cell") . "'>" . $healthRow['bmi'] . "</td>";
                    echo "</tr>";
                }
            } else {
                // If no health records found for the current patient
                echo "<tr><td colspan='9'>No health records available for this patient</td></tr>";
            }
            echo '</tbody>';
            echo '</table>';
        }
    } else {
        // If no patients found in the database
        echo "<p>No patients found in the database</p>";
    }
    ?>
</div>

<!-- Bootstrap JS and other scripts if needed -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
