<?php
// Read the JSON data from the cars.json file
$json_data = file_get_contents('../json/cars.json');
$cars = json_decode($json_data, true);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the car ID and quantity from the POST data
    $id = $_POST['id'];
    $quantity = $_POST['quantity']; // Get the passed quantity

    // Find the index of the car in the $cars array
    $car_index = null;
    foreach ($cars as $index => $car) {
        if ($car['id'] === $id) {
            $car_index = $index;
            break;
        }
    }

    // If the car is found
    if ($car_index !== null) {
        // Update the quantity of the car
        $cars[$car_index]['quantity'] = $cars[$car_index]['quantity'] + $quantity;

        // Encode the updated data as JSON and write it back to the file
        $updated_data = json_encode($cars, JSON_PRETTY_PRINT);
        file_put_contents('../json/cars.json', $updated_data);

        echo 'Quantity updated successfully';
    } else {
        echo 'Car not found';
    }
} else {
    echo 'Invalid request method';
}
