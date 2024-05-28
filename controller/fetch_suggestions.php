<?php
// fetch_suggestions.php
header('Content-Type: application/json');

// 读取 JSON 文件
$jsonFile = '../json/cars.json';
$jsonData = file_get_contents($jsonFile);
$cars = json_decode($jsonData, true);

$input = json_decode(file_get_contents('php://input'), true);
$query = strtolower($input['query']);

$suggestions = [];

foreach ($cars as $car) {
    $make = strtolower($car['make']);
    $model = strtolower($car['model']);
    $fullName = "$make $model";

    // 检查品牌、车型或品牌+车型是否包含搜索关键词
    if (strpos($make, $query) === 0 || strpos($model, $query) === 0 || strpos($fullName, $query) === 0) {
        $suggestions[] = $fullName;
    }
}

// 移除重复的建议
$suggestions = array_unique($suggestions);

// 限制返回的建议数量
$suggestions = array_slice($suggestions, 0, 5);

echo json_encode($suggestions);
