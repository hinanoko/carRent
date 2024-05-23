<?php
$json_data = file_get_contents('../json/cars.json');
$cars = json_decode($json_data, true);

$uncompleted_file = '../json/uncompleted.json';
if (file_exists($uncompleted_file) && filesize($uncompleted_file) > 0) {
    $uncompleted_data = file_get_contents($uncompleted_file);
    $uncompleted_item = json_decode($uncompleted_data, true);

    $car_index = null;
    foreach ($cars as $index => $car) {
        if ($car['id'] === $uncompleted_item['id']) {
            $car_index = $index;
            break;
        }
    }

    if ($car_index !== null) {
        $cars[$car_index]['quantity'] += $uncompleted_item['quantity'];

        $updated_data = json_encode($cars, JSON_PRETTY_PRINT);
        file_put_contents('../json/cars.json', $updated_data);

        file_put_contents($uncompleted_file, '');
        echo "Uncompleted items processed and updated";
    } else {
        echo "Car not found in uncompleted";
    }
} else {
    echo "No uncompleted items found";
}
