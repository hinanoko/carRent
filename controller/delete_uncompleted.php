<?php
$uncompleted_file = '../json/uncompleted.json';

// Check if the file exists
if (file_exists($uncompleted_file)) {
    // Delete the file content
    file_put_contents($uncompleted_file, '');
    echo 'Content deleted from uncompleted.json';
} else {
    echo 'File not found';
}
