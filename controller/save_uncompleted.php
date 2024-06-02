<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID and quantity from the POST data
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    // Create JSON data using the ID and quantity
    $data = array(
        'id' => $id,
        'quantity' => $quantity
    );

    // Write JSON data to a file
    $file = '../json/uncompleted.json';
    $json_data = json_encode($data);
    file_put_contents($file, $json_data);

    // Send a success response
    echo 'Data saved successfully';
} else {
    // If the request method is not POST, send an error message
    echo 'Invalid request method';
}
