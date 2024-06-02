<?php
$json_data = file_get_contents('../json/cars.json');
$cars = json_decode($json_data, true);

$uncompleted_file = '../json/uncompleted.json';

// Check if the uncompleted file exists and is not empty
if (file_exists($uncompleted_file) && filesize($uncompleted_file) > 0) {
    // Read the uncompleted data
    $uncompleted_data = file_get_contents($uncompleted_file);
    $uncompleted_item = json_decode($uncompleted_data, true);

    $car_index = null;

    // Search for the car in the list of cars
    foreach ($cars as $index => $car) {
        if ($car['id'] === $uncompleted_item['id']) {
            $car_index = $index;
            break;
        }
    }

    // If the car is found in the list
    if ($car_index !== null) {
        // Increase the quantity of the car in the list
        $cars[$car_index]['quantity'] += $uncompleted_item['quantity'];

        // Convert the updated data back to JSON format
        $updated_data = json_encode($cars, JSON_PRETTY_PRINT);

        // Write the updated data back to the cars.json file
        file_put_contents('../json/cars.json', $updated_data);

        // Clear the uncompleted file since it's processed
        file_put_contents($uncompleted_file, '');

        echo "Uncompleted items processed and updated";
    } else {
        // If the car is not found in the list
        echo "Car not found in uncompleted";
    }
} else {
    // If no uncompleted items are found
    echo "No uncompleted items found";
}
