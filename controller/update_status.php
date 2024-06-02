<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "123456";
$database = "assignment2";

$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the order ID from the POST data
$orderId = $_POST['order_id'];

echo "Order ID: " . $orderId . "\n";

// Update the order status in the database
$sql = "UPDATE `order` SET status = 'confirmed' WHERE carId = $orderId AND status = 'pending'";

if ($conn->query($sql) === TRUE) {
    echo "Order status updated successfully";
} else {
    echo "Error updating order status: " . $conn->error;
}

// Close the database connection
$conn->close();
