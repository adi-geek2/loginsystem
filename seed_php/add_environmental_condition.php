<?php
// Database connection settings
$servername = "localhost"; // Update as needed
$username = "root";        // Update as needed
$password = "";            // Update as needed
$dbname = "FarmerInformation"; // Update as needed

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $sowing_id = (int)$_POST["sowing_id"];
    $observation_date = $conn->real_escape_string(trim($_POST["observation_date"]));
    $temperature = !empty($_POST["temperature"]) ? (float)$_POST["temperature"] : NULL;
    $humidity = !empty($_POST["humidity"]) ? (float)$_POST["humidity"] : NULL;
    $rainfall = !empty($_POST["rainfall"]) ? (float)$_POST["rainfall"] : NULL;
    $soil_moisture = !empty($_POST["soil_moisture"]) ? (float)$_POST["soil_moisture"] : NULL;
    $notes = $conn->real_escape_string(trim($_POST["notes"]));

    // Build SQL query
    $sql = "INSERT INTO EnvironmentalConditions (SowingID, ObservationDate, Temperature, Humidity, Rainfall, SoilMoisture, Notes)
            VALUES ($sowing_id, '$observation_date', " . 
            ($temperature !== NULL ? $temperature : "NULL") . ", " . 
            ($humidity !== NULL ? $humidity : "NULL") . ", " . 
            ($rainfall !== NULL ? $rainfall : "NULL") . ", " . 
            ($soil_moisture !== NULL ? $soil_moisture : "NULL") . ", '$notes')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "New environmental condition added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add environmental condition</title>
</head>
<body>
    <a href="environmental_conditions.html">Back to environmental conditions management form</a>
</body>
</html>
