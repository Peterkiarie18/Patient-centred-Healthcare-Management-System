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
    <title>Graphical Health Data</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .chart {
            width: 550px; /* Adjust the width as needed */
            height: 350px; /* Adjust the height as needed */
            margin-bottom: 20px; /* Add margin to create vertical spacing between charts */

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
    float: right; 
}
table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
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
        <div class="mycontainer">
            <h2>Patients' Health Details</h2>
        <div class="row">
            <div class="col-md-6">
                <!-- chart containers -->
                <div class="chart">
                    <canvas id="temperatureChart"></canvas>
                </div>
                <div class="chart">
                    <canvas id="bloodPressureChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart">
                    <canvas id="bloodGlucoseChart"></canvas>
                </div>
                <div class="chart">
                    <canvas id="cholesterolChart"></canvas>
                </div>
            </div>
        </div>
    </div>
     <table>
  <tr>
    <th>Parameter</th>
    <th>Healthy Range</th>
    <th>Unhealthy Range</th>
    <th>Associated NCD</th>
  </tr>
  <tr>
    <td>Temperature (°C)</td>
    <td>Below 37.2</td>
    <td>Above 37.2</td>
    <td>Underlying infection, inflammation (may contribute to NCDs)</td>
  </tr>
  <tr>
    <td>Blood Pressure (mmHg)</td>
    <td>90 - 130</td>
    <td>Above 130</td>
    <td>Hypertension (High Blood Pressure),Cardiovascular Diseases (CVDs)</td>
  </tr>
  <tr>
    <td>Blood Glucose (mg/dL)</td>
    <td>Below 126</td>
    <td>Above 126</td>
    <td>Prediabetes, Type 2 Diabetes</td>
  </tr>
  <tr>
    <td>Cholesterol (mg/dL)</td>
    <td>Below 240</td>
    <td>Above 240</td>
    <td>Hypercholesterolemia, Cardiovascular Diseases (CVDs)</td>
  </tr>
  <tr>
    <td>Waist Circumference (cm)</td>
    <td>Below 102</td>
    <td>Above 102</td>
    <td>Abdominal Obesity, Type 2 Diabetes, CVDs, Cancers</td>
  </tr>
  <tr>
    <td>Body Mass Index (BMI)</td>
    <td>18.5 - 24.9</td>
    <td>Below 18.5<br>Above 24.9</td>
    <td>Underweight<br>Overweight/Obesity, Type 2 Diabetes, CVDs, Cancers</td>
  </tr>

    <!-- Custom JavaScript -->
        <script>
        $(document).ready(function() {
            // Fetch Temperature data from the server
            $.ajax({
                    url: 'get_temperature_data.php',
                    type: 'GET',
                    success: function(data) {
                        // Process the data and create the chart
                        createChart(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching temperature data:', status, error);
                    }
                });
            // Fetch blood pressure data from the server
            $.ajax({
                url: 'get_blood_pressure_data.php',
                type: 'GET',
                success: function(data) {
                    // Process the data and create the blood pressure chart
                    createBloodPressureChart(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching blood pressure data:', status, error);
                }
            });

            // Fetch blood glucose data from the server
            $.ajax({
                url: 'get_blood_glucose_data.php',
                type: 'GET',
                success: function(data) {
                    // Process the data and create the blood glucose chart
                    createBloodGlucoseChart(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching blood glucose data:', status, error);
                }
            });

            // Fetch cholesterol data from the server
            $.ajax({
                url: 'get_cholesterol_data.php',
                type: 'GET',
                success: function(data) {
                    // Process the data and create the cholesterol chart
                    createCholesterolChart(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cholesterol data:', status, error);
                }
            });
            // Function to create the line chart
                function createChart(data) {
                    // Parse the JSON data
                    var parsedData = JSON.parse(data);

                    // Extract dates and temperatures from the data
                    var dates = parsedData.map(function(item) {
                        return item.date;
                    });
                    var temperatures = parsedData.map(function(item) {
                        return item.temperature;
                    });

                    // Create the line chart
                    var ctx = document.getElementById('temperatureChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: dates,
                            datasets: [{
                                label: 'Temperature (°C)',
                                data: temperatures,
                                borderColor: 'red',
                                fill: false
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Date'
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Temperature (°C)'
                                    }
                            }
                        }
                    }
                });
            }

            // Function to create the blood pressure chart
            function createBloodPressureChart(data) {
                // Parse data if necessary
                var parsedData = JSON.parse(data);

                // Extract data for the chart
                var dates = parsedData.map(function(item) {
                    return item.date;
                });
                var bloodPressures = parsedData.map(function(item) {
                    return item.blood_pressure;
                });

                // Create the chart
                var ctx = document.getElementById('bloodPressureChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Blood Pressure (mmHg)',
                            data: bloodPressures,
                            borderColor: 'blue',
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Blood Pressure (mmHg)'
                                }
                            }
                        }
                    }
                });
            }

            // Function to create the blood glucose chart
            function createBloodGlucoseChart(data) {
                // Parse data if necessary
                var parsedData = JSON.parse(data);

                // Extract data for the chart
                var dates = parsedData.map(function(item) {
                    return item.date;
                });
                var bloodGlucoses = parsedData.map(function(item) {
                    return item.blood_glucose;
                });

                // Create the chart
                var ctx = document.getElementById('bloodGlucoseChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Blood Glucose (mg/dL)',
                            data: bloodGlucoses,
                            borderColor: 'green',
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Blood Glucose (mg/dL)'
                                }
                            }
                        }
                    }
                });
            }

            // Function to create the cholesterol chart
            function createCholesterolChart(data) {
                // Parse data if necessary
                var parsedData = JSON.parse(data);

                // Extract data for the chart
                var dates = parsedData.map(function(item) {
                    return item.date;
                });
                var cholesterols = parsedData.map(function(item) {
                    return item.cholesterol;
                });

                // Create the chart
                var ctx = document.getElementById('cholesterolChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Cholesterol (mg/dL)',
                            data: cholesterols,
                            borderColor: 'orange',
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Cholesterol (mg/dL)'
                                }
                            }
                        }
                    }
                });
            }
        });
        </script>
</body>
</html>
