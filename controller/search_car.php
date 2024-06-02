<?php
// Set the response content type to JSON
header('Content-Type: application/json');

// Decode the JSON input from the request
$input = json_decode(file_get_contents('php://input'), true);

// Get the search query from the input or set it to an empty string if not provided
$query = isset($input['query']) ? strtolower($input['query']) : '';

// Read the JSON data of cars from the file
$carsJson = file_get_contents('../json/cars.json');
$cars = json_decode($carsJson, true);

// Perform a search based on the query
if (!empty($query)) {
    // Filter cars based on the search query
    $searchResults = array_filter($cars, function ($car) use ($query) {
        $make = strtolower($car['make']);
        $model = strtolower($car['model']);
        $type = strtolower($car['type']);
        $fullName = "$make $model";

        // Check if make, model, type, or full name contains the search query
        return strpos($make, $query) !== false ||
            strpos($model, $query) !== false ||
            strpos($type, $query) !== false ||
            strpos($fullName, $query) !== false;
    });
} else {
    // If the query is empty, randomly select 5 cars
    $keys = array_rand($cars, 5);
    $searchResults = array_intersect_key($cars, array_flip($keys));
}

// If no search results were found, randomly select 5 cars from the full list
if (empty($searchResults)) {
    $keys = array_rand($cars, 5);
    $searchResults = array_intersect_key($cars, array_flip($keys));
}

// Encode and output the search results as JSON
echo json_encode(array_values($searchResults));
