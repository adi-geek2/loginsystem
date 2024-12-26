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
    $sowing_id = (int)$_POST["sowing_id"];
    $stage_name = $conn->real_escape_string(trim($_POST["stage_name"]));
    $observed_date = $conn->real_escape_string(trim($_POST["observed_date"]));
    $notes = $conn->real_escape_string(trim($_POST["notes"]));

    // Validate required fields
    if (empty($sowing_id) || empty($stage_name) || empty($observed_date)) {
        echo "Sowing ID, Stage Name, and Observed Date are required.";
        exit;
    }

    // Insert data into the GrowthStages table
    $sql = "INSERT INTO GrowthStages (SowingID, StageName, ObservedDate, Notes)
            VALUES ($sowing_id, '$stage_name', '$observed_date', '$notes')";

    if ($conn->query($sql) === TRUE) {
        echo "New growth stage added successfully!";
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
    <title>Add growth stages</title>
</head>
<body>
    <a href="growth_stages.html">Back to growth stages management form</a>
</body>
</html>
