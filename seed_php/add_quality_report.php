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
    $test_id = (int)$_POST["test_id"];
    $report_date = $conn->real_escape_string(trim($_POST["report_date"]));
    $certification_status = $conn->real_escape_string(trim($_POST["certification_status"]));
    $certification_body = !empty($_POST["certification_body"]) ? $conn->real_escape_string(trim($_POST["certification_body"])) : NULL;
    $report_summary = !empty($_POST["report_summary"]) ? $conn->real_escape_string(trim($_POST["report_summary"])) : NULL;

    // Validate required fields
    if (empty($test_id) || empty($report_date) || empty($certification_status)) {
        echo "All required fields must be filled out.";
        exit;
    }

    // Insert data into the QualityReports table
    $sql = "INSERT INTO QualityReports (TestID, ReportDate, CertificationStatus, CertificationBody, ReportSummary)
            VALUES ($test_id, '$report_date', '$certification_status', " .
            ($certification_body !== NULL ? "'$certification_body'" : "NULL") . ", " .
            ($report_summary !== NULL ? "'$report_summary'" : "NULL") . ")";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "New quality report added successfully!";
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
    <title>Quality Reports Management</title>
</head>
<body>
    <a href="quality_reports.html">Back to quality reports management form</a>
</body>
</html>