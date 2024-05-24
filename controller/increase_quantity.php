<?php
$json_data = file_get_contents('../json/cars.json');
$cars = json_decode($json_data, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $quantity = $_POST['quantity']; // 获取传递的数量

    $car_index = null;
    foreach ($cars as $index => $car) {
        if ($car['id'] === $id) {
            $car_index = $index;
            break;
        }
    }

    if ($car_index !== null) {
        $cars[$car_index]['quantity']++;

        $updated_data = json_encode($cars, JSON_PRETTY_PRINT);
        file_put_contents('../json/cars.json', $updated_data);

        echo 'Quantity updated successfully';
    } else {
        echo 'Car not found';
    }
} else {
    echo 'Invalid request method';
}
