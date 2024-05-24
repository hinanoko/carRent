<?php
// 读取JSON文件
$jsonData = file_get_contents('../json/uncompleted.json');

// 将JSON数据解码为PHP关联数组
$data = json_decode($jsonData, true);

// 修改quantity的值
$data['quantity'] = (int)$data['quantity'] + 1;

// 将修改后的数据编码为JSON格式
$updatedJsonData = json_encode($data, JSON_PRETTY_PRINT);

// 将修改后的JSON数据写回文件
file_put_contents('../json/uncompleted.json', $updatedJsonData);

echo "JSON文件已成功更新!";
