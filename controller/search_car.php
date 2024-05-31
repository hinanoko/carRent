<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$query = isset($input['query']) ? strtolower($input['query']) : '';

$carsJson = file_get_contents('../json/cars.json');
$cars = json_decode($carsJson, true);

if (!empty($query)) {
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
} else {
    // 如果查询为空，随机选择 5 个汽车
    $keys = array_rand($cars, 5);
    $searchResults = array_intersect_key($cars, array_flip($keys));
}

if (empty($searchResults)) {
    $keys = array_rand($cars, 5);
    $searchResults = array_intersect_key($cars, array_flip($keys));
}

echo json_encode(array_values($searchResults));
