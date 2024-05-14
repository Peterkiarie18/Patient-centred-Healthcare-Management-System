<?php
// Include your database connection configuration file
include 'config.php';

// Start session to retrieve logged-in user's ID
session_start();
$user_id = $_SESSION['user_id']; 

if(!isset($user_id)){
   header('location:userlogin.php');
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User's Health Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    .logout-container {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .logout-button {
        background-color: #f44336; /* Red color */
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .logout-button:hover {
        background-color: #d32f2f; /* Darker red color on hover */
    }
</style>

</head>
<body>
    <div class="logout-container">
    <form action="Ulogout.php" method="post">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</div>
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
    <div class="container">
        <h2>Patients' Health Details</h2>
    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Temperature (°C)</th>
                    <th>Blood Pressure (mmHg)</th>
                    <th>Blood Glucose (mg/dL)</th>
                    <th>Cholesterol (mg/dL)</th>
                    <th>Waist Circumference (cm)</th>
                    <th>Weight (kg)</th>
                    <th>Height (cm)</th>
                    <th>BMI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if user is logged in
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];
                    // SQL query to fetch patient details for the logged-in user
                    $sql = "SELECT * FROM health_data WHERE user_id = $userId ORDER BY date";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Check if any data is in the unhealthy range
                            $unhealthy = false;
                            // Check each parameter and apply CSS class if it's unhealthy
                            // You need to adjust these conditions based on your specific health guidelines
                            if ($row['temperature'] > 37.2 || $row['temperature'] < 36.1 ||
                                $row['blood_pressure'] > 130 || $row['blood_pressure'] < 90 ||
                                $row['blood_glucose'] > 126 ||
                                $row['cholesterol'] > 240 ||
                                $row['waist_circumference'] > 102 ||
                                $row['bmi'] < 18.5 || $row['bmi'] > 24.9) {
                                $unhealthy = true;
                            }
                            // Output table rows with patient details
                            echo "<tr>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td class='" . ($unhealthy && $row['temperature'] > 37.2 ? "red-cell" : "green-cell") . "'>" . $row['temperature'] . "</td>";
                            echo "<td class='" . ($unhealthy && ($row['blood_pressure'] > 130 || $row['blood_pressure'] < 90) ? "red-cell" : "green-cell") . "'>" . $row['blood_pressure'] . "</td>";
                            echo "<td class='" . ($unhealthy && $row['blood_glucose'] > 126 ? "red-cell" : "green-cell") . "'>" . $row['blood_glucose'] . "</td>";
                            echo "<td class='" . ($unhealthy && $row['cholesterol'] > 240 ? "red-cell" : "green-cell") . "'>" . $row['cholesterol'] . "</td>";
                            echo "<td class='" . ($unhealthy && $row['waist_circumference'] > 102 ? "red-cell" : "green-cell") . "'>" . $row['waist_circumference'] . "</td>";
                            echo "<td>" . $row['weight'] . "</td>";
                            echo "<td>" . $row['height'] . "</td>";
                            echo "<td class='" . ($unhealthy && ($row['bmi'] < 18.5 || $row['bmi'] > 24.9) ? "red-cell" : "green-cell") . "'>" . $row['bmi'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No data available</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Please log in to view health details</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Download button -->
<a href="download.php" class="btn btn-success mb-3">Download Records</a>

    </div>

    <!-- Bootstrap JS and other scripts if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
