<?php
// Read the cars.json file
$json_data = file_get_contents('../json/cars.json');
$cars = json_decode($json_data, true);

// Get the car ID from the query string
$carId = $_GET['carId'];

// Initialize the selected car variable
$selectedCar = null;

// Find the car data that matches the provided car ID
foreach ($cars as $car) {
    if ($car['id'] === $carId) {
        $selectedCar = $car;
        break;
    }
}

// If a matching car is found, output its quantity
if ($selectedCar !== null) {
    echo $selectedCar['quantity'];
} else {
    echo 'Car not found';
}
