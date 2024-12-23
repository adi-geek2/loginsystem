<?php
// Database connection details
$host = 'localhost';
$dbname = 'farmerinformation';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $gender = $_POST['Gender'];
        $dateOfBirth = $_POST['DateOfBirth'];
        $contactNumber = $_POST['ContactNumber'];
        $email = $_POST['Email'] ?? null; // Optional field
        $address = $_POST['Address'];
        $city = $_POST['City'];
        $state = $_POST['State'];
        $country = $_POST['Country'];
        $zipCode = $_POST['ZipCode'];

        // Prepare SQL to insert data
        $sql = "INSERT INTO Farmers (FirstName, LastName, Gender, DateOfBirth, ContactNumber, Email, Address, City, State, Country, ZipCode) 
                VALUES (:FirstName, :LastName, :Gender, :DateOfBirth, :ContactNumber, :Email, :Address, :City, :State, :Country, :ZipCode)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':FirstName', $firstName);
        $stmt->bindParam(':LastName', $lastName);
        $stmt->bindParam(':Gender', $gender);
        $stmt->bindParam(':DateOfBirth', $dateOfBirth);
        $stmt->bindParam(':ContactNumber', $contactNumber);
        $stmt->bindParam(':Email', $email);
        $stmt->bindParam(':Address', $address);
        $stmt->bindParam(':City', $city);
        $stmt->bindParam(':State', $state);
        $stmt->bindParam(':Country', $country);
        $stmt->bindParam(':ZipCode', $zipCode);

        // Execute SQL
        if ($stmt->execute()) {
            echo "Farmer added successfully!";
        } else {
            echo "Failed to add farmer.";
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
    <title>Add Farmer</title>
</head>
<body>
    <a href="farmers.html">Back to farmer details form</a>
</body>
</html>
