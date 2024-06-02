<?php
// Read JSON file
$jsonData = file_get_contents('../json/uncompleted.json');

// Decode JSON data into PHP associative array
$data = json_decode($jsonData, true);

// Modify the value of 'quantity'
$data['quantity'] = (int)$data['quantity'] - 1;

// Encode the modified data back to JSON format
$updatedJsonData = json_encode($data, JSON_PRETTY_PRINT);

// Write the updated JSON data back to the file
file_put_contents('../json/uncompleted.json', $updatedJsonData);

echo "JSON file has been successfully updated!";
