<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$query = isset($input['query']) ? strtolower($input['query']) : '';

$carsJson = file_get_contents('../json/cars.json');
$cars = json_decode($carsJson, true);

$searchResults = array_filter($cars, function ($car) use ($query) {
    $make = strtolower($car['make']);
    $model = strtolower($car['model']);
    $type = strtolower($car['type']);
    $fullName = "$make $model";

    // 检查品牌、车型、类型或品牌+车型是否包含搜索关键词
    return strpos($make, $query) !== false ||
        strpos($model, $query) !== false ||
        strpos($type, $query) !== false ||
        strpos($fullName, $query) !== false;
});

if (empty($searchResults)) {
    $searchResults = array_slice($cars, 0, 5);
}

echo json_encode(array_values($searchResults));
