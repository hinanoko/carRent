<?php
// 连接数据库
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "assignment2";

$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 获取表单数据
$quantity = $_POST['quantity'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$name = $_POST['name'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$license = $_POST['license'];
$carId = $_POST['carId'];
$totalPrice = $_POST['totalPrice'];

// 插入数据到数据库
$sql = "INSERT INTO `order` (quantity, startDate, endDate, name, mobile, email, license, status, price, carID)
        VALUES ('$quantity', '$startDate', '$endDate', '$name', '$mobile', '$email', '$license', 'pending', '$totalPrice', '$carId')";

if ($conn->query($sql) === TRUE) {
    echo "Order submitted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
