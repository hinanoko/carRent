<?php
// 读取 cars.json 文件
$json_data = file_get_contents('../json/cars.json');
$cars = json_decode($json_data, true);

// 获取汽车 ID
$carId = $_GET['carId'];

// 查找匹配的车辆数据
$selectedCar = null;
foreach ($cars as $car) {
    if ($car['id'] === $carId) {
        $selectedCar = $car;
        break;
    }
}

// 如果找到匹配的车辆数据
if ($selectedCar !== null) {
    echo $selectedCar['quantity'];
} else {
    echo 'Car not found';
}
