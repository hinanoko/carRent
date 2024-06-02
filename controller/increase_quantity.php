<?php
// Read the JSON data from the file
$json_data = file_get_contents('../json/cars.json');
$cars = json_decode($json_data, true);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID and quantity from the POST data
    $id = $_POST['id'];
    $quantity = $_POST['quantity']; // Get the passed quantity

    $car_index = null;
    // Loop through the cars array to find the car with the specified ID
    foreach ($cars as $index => $car) {
        if ($car['id'] === $id) {
            // If the car is found, update its quantity
            $car_index = $index;
            break;
        }
    }

    if ($car_index !== null) {
        // Increment the quantity of the selected car
        $cars[$car_index]['quantity']++;

        // Encode the updated data back to JSON format
        $updated_data = json_encode($cars, JSON_PRETTY_PRINT);

        // Write the updated JSON data back to the file
        file_put_contents('../json/cars.json', $updated_data);

        echo 'Quantity updated successfully';
    } else {
        echo 'Car not found';
    }
} else {
    // If the request method is not POST, return an error message
    echo 'Invalid request method';
}
