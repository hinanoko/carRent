<?php
// Database connection information
$servername = "localhost";
$username = "root";
$password = "123456";
$database = "assignment2";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Empty the 'order' table data
$table_name = 'order';
$truncate_sql = "TRUNCATE TABLE `$table_name`";

if ($conn->query($truncate_sql) === TRUE) {
    echo "Table $table_name has been emptied.";
} else {
    echo "Error truncating table $table_name: " . $conn->error;
}

// Close connection
$conn->close();
