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
    $supplier_name = $conn->real_escape_string(trim($_POST["supplier_name"]));
    $contact_number = $conn->real_escape_string(trim($_POST["contact_number"]));
    $email = $conn->real_escape_string(trim($_POST["email"]));
    $address = $conn->real_escape_string(trim($_POST["address"]));
    $city = $conn->real_escape_string(trim($_POST["city"]));
    $state = $conn->real_escape_string(trim($_POST["state"]));
    $country = $conn->real_escape_string(trim($_POST["country"]));
    $zip_code = $conn->real_escape_string(trim($_POST["zip_code"]));

    // Insert data into the SeedSuppliers table
    $sql = "INSERT INTO SeedSuppliers (SupplierName, ContactNumber, Email, Address, City, State, Country, ZipCode)
            VALUES ('$supplier_name', '$contact_number', '$email', '$address', '$city', '$state', '$country', '$zip_code')";

    if ($conn->query($sql) === TRUE) {
        echo "New supplier added successfully!";
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
    <title>Supplier management</title>
</head>
<body>
    <a href="seed_suppliers.html">Back to supplier management form</a>
</body>
</html>