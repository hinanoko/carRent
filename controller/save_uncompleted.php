<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    // 创建 JSON 数据
    $data = array(
        'id' => $id,
        'quantity' => $quantity
    );

    // 将 JSON 数据写入文件
    $file = '../json/uncompleted.json';
    $json_data = json_encode($data);
    file_put_contents($file, $json_data);

    // 返回成功响应
    echo 'Data saved successfully';
} else {
    echo 'Invalid request method';
}
