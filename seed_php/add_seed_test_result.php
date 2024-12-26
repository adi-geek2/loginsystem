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
    $test_id = (int)$_POST["test_id"];
    $parameter = $conn->real_escape_string(trim($_POST["parameter"]));
    $value = (float)$_POST["value"];
    $unit = !empty($_POST["unit"]) ? $conn->real_escape_string(trim($_POST["unit"])) : NULL;
    $pass_fail = $conn->real_escape_string(trim($_POST["pass_fail"]));
    $notes = !empty($_POST["notes"]) ? $conn->real_escape_string(trim($_POST["notes"])) : NULL;

    // Validate required fields
    if (empty($test_id) || empty($parameter) || empty($value) || empty($pass_fail)) {
        echo "All required fields must be filled out.";
        exit;
    }

    // Insert data into the SeedTestResults table
    $sql = "INSERT INTO SeedTestResults (TestID, Parameter, Value, Unit, PassFail, Notes)
            VALUES ($test_id, '$parameter', $value, " . 
            ($unit !== NULL ? "'$unit'" : "NULL") . ", '$pass_fail', " . 
            ($notes !== NULL ? "'$notes'" : "NULL") . ")";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "New seed test result added successfully!";
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
    <title>Seed Test Results Management</title>
</head>
<body>
    <a href="seed_test_results.html">Back to seed test result management form</a>
</body>
</html>