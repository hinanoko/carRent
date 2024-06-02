<?php
// Read the JSON data from the cars.json file
$json_data = file_get_contents('../json/cars.json');
$cars = json_decode($json_data, true);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the car ID and quantity from the POST data
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    // Initialize the car index to null
    $car_index = null;

    // Find the index of the car with the matching ID
    foreach ($cars as $index => $car) {
        if ($car['id'] === $id) {
            $car_index = $index;
            break;
        }
    }

    // If a matching car is found
    if ($car_index !== null) {
        // Decrease the quantity of the car by one
        $cars[$car_index]['quantity']--;

        // Encode the updated data as JSON
        $updated_data = json_encode($cars, JSON_PRETTY_PRINT);

        // Write the updated JSON data back to the cars.json file
        file_put_contents('../json/cars.json', $updated_data);

        // Output a success message
        echo 'Quantity updated successfully';
    } else {
        // Output an error message if the car is not found
        echo 'Car not found';
    }
} else {
    // Output an error message for invalid request method
    echo 'Invalid request method';
}
