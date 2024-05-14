<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Data Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Health Data Form</h2>
        <form id="healthForm" action="submitform.php" method="post">
            <?php
                // Establish database connection
                $conn = new mysqli('localhost', 'root', '', 'health');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch users from database
                $sql = "SELECT user_id, username FROM users";
                $result = $conn->query($sql);

                // Populate dropdown menu with user names
                if ($result->num_rows > 0) {
                    echo "<div class='form-group'>";
                    echo "<label for='userSelect'>Select User:</label>";
                    echo "<select class='form-control' id='userSelect' name='userId' required>";
                    echo "<option value=''>Select User</option>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['user_id'] . "'>" . $row['username'] . "</option>";
                    }
                    echo "</select>";
                    echo "</div>";
                } else {
                    echo "<p>No users found.</p>";
                }

                // Close database connection
                $conn->close();
            ?>

            <!-- Rest of the form fields -->
            <div class="form-group">
                <label for="temperature">Temperature (°C):</label>
                <input type="number" class="form-control" id="temperature" name="temperature" step="0.1" required>
            </div>
            <div class="form-group">
                <label for="bloodPressure">Blood Pressure (mmHg):</label>
                <input type="number" class="form-control" id="bloodPressure" name="bloodPressure" required>
            </div>
            <div class="form-group">
                <label for="bloodGlucose">Blood Glucose (mg/dl):</label>
                <input type="number" class="form-control" id="bloodGlucose" name="bloodGlucose" required>
            </div>
            <div class="form-group">
                <label for="cholesterol">Cholesterol (mg/dl):</label>
                <input type="number" class="form-control" id="cholesterol" name="cholesterol" required>
            </div>
            <div class="form-group">
                <label for="waistCircumference">Waist Circumference:</label>
                <input type="number" class="form-control" id="waistCircumference" name="waistCircumference" required>
            </div>
            <div class="form-group">
                <label for="weight">Weight (kg):</label>
                <input type="number" class="form-control" id="weight" name="weight" step="0.1" required>
            </div>
            <div class="form-group">
                <label for="height">Height (cm):</label>
                <input type="number" class="form-control" id="height" name="height" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div id="bmiResult"></div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
    </div>
    
</body>
</html>
