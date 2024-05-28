<?php
// 读取 uncompleted.json 文件
$json_data = file_get_contents('../json/uncompleted.json');
$data = json_decode($json_data, true);

// 检查是否有 ID 参数
if (isset($_GET['id'])) {
    $carId = $_GET['id'];

    // 检查 ID 是否匹配
    if (isset($data['id']) && $data['id'] === $carId) {
        // 返回数量
        echo $data['quantity'];
    } else {
        echo 0; // 如果 ID 不匹配，返回 0
    }
} else {
    // 处理没有提供 ID 参数的情况
    echo 'No car ID provided.';
}
