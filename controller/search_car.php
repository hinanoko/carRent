<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$query = isset($input['query']) ? strtolower($input['query']) : '';

$carsJson = file_get_contents('../json/cars.json');
$cars = json_decode($carsJson, true);

$searchResults = array_filter($cars, function ($car) use ($query) {
    return strpos(strtolower($car['make']), $query) !== false ||
        strpos(strtolower($car['model']), $query) !== false ||
        strpos(strtolower($car['type']), $query) !== false;
});

if (empty($searchResults)) {
    $searchResults = array_slice($cars, 0, 5);
}

echo json_encode(array_values($searchResults));
