<?php
// fetch_suggestions.php
header('Content-Type: application/json');

// Read JSON file
$jsonFile = '../json/cars.json';
$jsonData = file_get_contents($jsonFile);
$cars = json_decode($jsonData, true);

// Decode input JSON data
$input = json_decode(file_get_contents('php://input'), true);
$query = strtolower($input['query']);

$suggestions = [];

// Iterate through cars to find matching suggestions
foreach ($cars as $car) {
    $make = strtolower($car['make']);
    $model = strtolower($car['model']);
    $fullName = "$make $model";

    // Check if make, model, or full name contains the search query
    if (strpos($make, $query) === 0 || strpos($model, $query) === 0 || strpos($fullName, $query) === 0) {
        $suggestions[] = $fullName;
    }
}

// Remove duplicate suggestions
$suggestions = array_unique($suggestions);

// Limit the number of suggestions returned
$suggestions = array_slice($suggestions, 0, 5);

echo json_encode($suggestions);
