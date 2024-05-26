<?php
// 连接到数据库
$servername = "localhost";
$username = "root";
$password = "123456";
$database = "assignment2";

$conn = new mysqli($servername, $username, $password, $database);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 获取订单 ID
$orderId = $_POST['order_id'];

echo "Order ID: " . $orderId . "\n";
// 更新订单状态
$sql = "UPDATE `order` SET status = 'confirmed' WHERE carId = $orderId AND status = 'pending'";

if ($conn->query($sql) === TRUE) {
    echo "Order status updated successfully";
} else {
    echo "Error updating order status: " . $conn->error;
}

$conn->close();
