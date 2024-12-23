<?php
// Database connection details
$host = 'localhost';
$dbname = 'farmerinformation';
$username = 'root';
$password = '';

try {
    // Establish database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $farmerID = $_POST['FarmerID'];
        $surveyNumber = $_POST['SurveyNumber'] ?? null;
        $hobali = $_POST['Hobali'] ?? null;
        $village = $_POST['Village'] ?? null;
        $taluka = $_POST['Taluka'] ?? null;
        $district = $_POST['District'] ?? null;
        $farmName = $_POST['FarmName'] ?? null;
        $farmLocation = $_POST['FarmLocation'];
        $farmSize = $_POST['FarmSize'];
        $primaryCrop = $_POST['PrimaryCrop'] ?? null;
        $irrigationType = $_POST['IrrigationType'] ?? null;
        $soilType = $_POST['SoilType'] ?? null;

        // Prepare SQL to insert data
        $sql = "INSERT INTO Farms (FarmerID, SurveyNumber, Hobali, Village, Taluka, District, FarmName, FarmLocation, FarmSize, PrimaryCrop, IrrigationType, SoilType) 
                VALUES (:FarmerID, :SurveyNumber, :Hobali, :Village, :Taluka, :District, :FarmName, :FarmLocation, :FarmSize, :PrimaryCrop, :IrrigationType, :SoilType)";

        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':FarmerID', $farmerID, PDO::PARAM_INT);
        $stmt->bindParam(':SurveyNumber', $surveyNumber);
        $stmt->bindParam(':Hobali', $hobali);
        $stmt->bindParam(':Village', $village);
        $stmt->bindParam(':Taluka', $taluka);
        $stmt->bindParam(':District', $district);
        $stmt->bindParam(':FarmName', $farmName);
        $stmt->bindParam(':FarmLocation', $farmLocation);
        $stmt->bindParam(':FarmSize', $farmSize);
        $stmt->bindParam(':PrimaryCrop', $primaryCrop);
        $stmt->bindParam(':IrrigationType', $irrigationType);
        $stmt->bindParam(':SoilType', $soilType);

        // Execute SQL
        if ($stmt->execute()) {
            echo "Farm details added successfully!";
        } else {
            echo "Failed to add farm details.";
        }
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add farm</title>
</head>
<body>
    <a href="farms.html">Back to farm details form</a>
</body>
</html>