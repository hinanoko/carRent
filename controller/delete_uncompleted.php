<?php
$uncompleted_file = '../json/uncompleted.json';

// 检查文件是否存在
if (file_exists($uncompleted_file)) {
    // 删除文件内容
    file_put_contents($uncompleted_file, '');
    echo 'Content deleted from uncompleted.json';
} else {
    echo 'File not found';
}
