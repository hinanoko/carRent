<?php
// 数据库连接信息
$servername = "localhost";
$username = "root";
$password = "123456";
$database = "assignment2";

// 创建连接
$conn = new mysqli($servername, $username, $password, $database);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 清空 'order' 表数据
$table_name = 'order';
$truncate_sql = "TRUNCATE TABLE `$table_name`";

if ($conn->query($truncate_sql) === TRUE) {
    echo "表 $table_name 已被清空。";
} else {
    echo "清空表 $table_name 时出错: " . $conn->error;
}

// 关闭连接
$conn->close();
