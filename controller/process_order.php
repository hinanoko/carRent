<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "assignment2";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data from POST request
$quantity = $_POST['quantity'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$name = $_POST['name'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$license = $_POST['license'];
$carId = $_POST['carId'];
$totalPrice = $_POST['totalPrice'];

// Insert data into the database
$sql = "INSERT INTO `order` (quantity, startDate, endDate, name, mobile, email, license, status, price, carID)
        VALUES ('$quantity', '$startDate', '$endDate', '$name', '$mobile', '$email', '$license', 'pending', '$totalPrice', '$carId')";

if ($conn->query($sql) === TRUE) {
    echo "Order submitted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
