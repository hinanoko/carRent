<?php
// Read the uncompleted.json file
$json_data = file_get_contents('../json/uncompleted.json');
$data = json_decode($json_data, true);

// Check if the ID parameter is provided
if (isset($_GET['id'])) {
    $carId = $_GET['id'];

    // Check if the ID matches
    if (isset($data['id']) && $data['id'] === $carId) {
        // Return the quantity
        echo $data['quantity'];
    } else {
        echo 0; // If the ID doesn't match, return 0
    }
} else {
    // Handle the case when no car ID is provided
    echo 'No car ID provided.';
}
