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
    $seed_id = (int)$_POST["seed_id"];
    $farmer_id = (int)$_POST["farmer_id"];
    $sowing_date = $conn->real_escape_string(trim($_POST["sowing_date"]));
    $field_location = $conn->real_escape_string(trim($_POST["field_location"]));
    $land_size = (float)$_POST["land_size"];
    $sowing_method = $conn->real_escape_string(trim($_POST["sowing_method"]));
    $fertilizer_used = $conn->real_escape_string(trim($_POST["fertilizer_used"]));
    $irrigation_type = $conn->real_escape_string(trim($_POST["irrigation_type"]));
    $expected_harvest_date = !empty($_POST["expected_harvest_date"]) ? $conn->real_escape_string(trim($_POST["expected_harvest_date"])) : NULL;
    $notes = $conn->real_escape_string(trim($_POST["notes"]));

    // Build SQL query
    $sql = "INSERT INTO SeedSowing (SeedID, FarmerID, SowingDate, FieldLocation, LandSize, SowingMethod, FertilizerUsed, IrrigationType, ExpectedHarvestDate, Notes)
            VALUES ($seed_id, $farmer_id, '$sowing_date', '$field_location', $land_size, '$sowing_method', '$fertilizer_used', '$irrigation_type', " . ($expected_harvest_date ? "'$expected_harvest_date'" : "NULL") . ", '$notes')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "New sowing record added successfully!";
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
    <title>Seed sowing management</title>
</head>
<body>
    <a href="seed_sowing.html">Back to seed sowing management form</a>
</body>
</html>