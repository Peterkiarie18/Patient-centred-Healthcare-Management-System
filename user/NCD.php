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
    <title>Understanding Non-Communicable Diseases (NCDs)</title>
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background-color: #007bff;
    color: #fff;
    padding: 20px;
    text-align: center;
}

header h1 {
    margin: 0;
}

main {
    padding: 20px;
}

footer {
    background-color: #007bff;
    color: #fff;
    text-align: center;
    padding: 10px;
    position: fixed;
    bottom: 0;
    width: 100%;
}

footer p {
    margin: 0;
}

/* Section Styles */
section {
    margin-bottom: 30px;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

section h2 {
    margin-top: 0;
}

section ul {
    list-style-type: none;
    padding: 0;
}

section ul li {
    margin-bottom: 10px;
}

/* Link Styles */
a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
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

    </style>>
</head>
<body>
    <header>
        <h1>Understanding Non-Communicable Diseases (NCDs)</h1>
    </header>
    <main>
        <section id="overview">
            <h2>Overview</h2>
            <p>Non-communicable diseases (NCDs) are chronic health conditions that are not primarily caused by infectious agents. They are a leading cause of death and disability worldwide, posing a significant challenge to healthcare systems globally, including here in Kenya. The good news is that many NCDs can be prevented or managed effectively through healthy lifestyle choices.</p>
        </section>

        <section id="ncd-categories">
            <h2>NCD Categories</h2>
            <ul>
                <li><strong>Cardiovascular Diseases (CVDs):</strong> Heart disease, stroke, and heart failure. High blood pressure, cholesterol, and unhealthy weight are major risk factors.</li>
                <li><strong>Diabetes:</strong> A chronic condition affecting blood sugar regulation.</li>
                <li><strong>Chronic Respiratory Diseases:</strong> Conditions like chronic obstructive pulmonary disease (COPD) that affect breathing. Smoking is a significant risk factor.</li>
                <li><strong>Cancers:</strong> Uncontrolled cell growth that can invade other tissues. Lifestyle factors like diet, tobacco use, and sun exposure can influence cancer risk.</li>
                <li><strong>Mental Health Disorders:</strong> Depression, anxiety, and other mental health conditions can significantly impact daily life.</li>
            </ul>
        </section>

        <section id="health-data">
            <h2>Health Data</h2>
            <p>Monitoring various health data points can help identify potential areas of concern and guide prevention and management strategies.</p>
            <ul>
                <li><strong>Temperature:</strong> Fever can be a sign of infection or inflammation, contributing to long-term health problems.</li>
                <li><strong>Blood Glucose:</strong> High blood sugar levels are a hallmark of diabetes, damaging nerves, eyes, kidneys, and other organs.</li>
                <li><strong>Blood Pressure:</strong> High blood pressure strains the heart and blood vessels, increasing the risk of heart disease and stroke.</li>
                <li><strong>Cholesterol:</strong> High LDL cholesterol levels contribute to plaque buildup in arteries, increasing the risk of cardiovascular diseases.</li>
                <li><strong>Waist Circumference:</strong> Excess abdominal fat increases the risk of type 2 diabetes, heart disease, and certain cancers.</li>
                <li><strong>Weight and Height (BMI):</strong> Overweight and obesity are significant risk factors for several NCDs.</li>
            </ul>
        <br>
        <br>
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
</table>
</section>
        <section id="prevention-strategies">
            <h2>Prevention Strategies</h2>
            <p>Adopting healthy lifestyle choices can significantly reduce the risk of developing NCDs.</p>
            <ul>
                <li><strong>Maintain a Healthy Weight:</strong> Balance diet and exercise to achieve and maintain a healthy weight.</li>
                <li><strong>Eat a Balanced Diet:</strong> Prioritize fruits, vegetables, whole grains, and lean protein while limiting unhealthy fats and sugars.</li>
                <li><strong>Be Active:</strong> Engage in regular physical activity for at least 150 minutes per week.</li>
                <li><strong>Manage Stress:</strong> Practice relaxation techniques to reduce chronic stress levels.</li>
                <li><strong>Don't Smoke:</strong> Quit smoking to lower the risk of heart disease, stroke, lung disease, and cancer.</li>
                <li><strong>Limit Alcohol Consumption:</strong> Moderate alcohol intake to reduce the risk of liver damage and certain cancers.</li>
                <li><strong>Get Regular Checkups:</strong> Schedule routine checkups with healthcare providers for early detection and intervention.</li>
            </ul>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Patient Centered System</p>
    </footer>
</body>
</html>
