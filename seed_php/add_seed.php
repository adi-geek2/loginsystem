<?php
// Database connection settings
$servername = "localhost"; // Update as needed
$username = "root";        // Update as needed
$password = "";            // Update as needed
$dbname = "loginsystem"; // Update as needed

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $seed_name = $conn->real_escape_string(trim($_POST["seed_name"]));
    $scientific_name = $conn->real_escape_string(trim($_POST["scientific_name"]));
    $seed_type = $conn->real_escape_string(trim($_POST["seed_type"]));
    $crop_type = $conn->real_escape_string(trim($_POST["crop_type"]));
    $suitable_season = $conn->real_escape_string(trim($_POST["suitable_season"]));
    $days_to_maturity = (int)$_POST["days_to_maturity"];
    $yield_per_acre = (float)$_POST["yield_per_acre"];
    $origin = $conn->real_escape_string(trim($_POST["origin"]));
    $storage_conditions = $conn->real_escape_string(trim($_POST["storage_conditions"]));

    // Insert data into the Seeds table
    $sql = "INSERT INTO Seeds (SeedName, ScientificName, SeedType, CropType, SuitableSeason, DaysToMaturity, YieldPerAcre, Origin, StorageConditions)
            VALUES ('$seed_name', '$scientific_name', '$seed_type', '$crop_type', '$suitable_season', $days_to_maturity, $yield_per_acre, '$origin', '$storage_conditions')";

    if ($conn->query($sql) === TRUE) {
        echo "New seed added successfully!";
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
    <title>Seed management</title>
</head>
<body>
    <a href="seeds_management.html">Back to Seed management form</a>
</body>
</html>