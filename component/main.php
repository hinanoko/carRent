<!DOCTYPE html>
<html>

<head>
    <style>
        /* Grid container styles */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            border-radius: 8px;
        }

        /* Grid item styles */
        .grid-item {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            background-color: cadetblue;
        }

        /* Product image styles */
        .product-image {
            width: 200px;
            height: 150px;
        }

        /* Page container styles */
        .page-container {
            text-align: center;
            margin-top: 20px;
        }

        /* Page image styles */
        .page-image {
            width: 800px;
            height: 550px;
        }

        /* Text styles */
        .text {
            margin-top: 20px;
            font-size: 24px;
            font-family: Arial, sans-serif;
        }

        /* Grid item hover effect */
        .grid-item:hover {
            background-color: #ccc;
        }

        /* Rent button styles */
        .rent-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        /* Disabled rent button styles */
        .rent-button:disabled {
            background-color: #FF0000;
            color: #FFFFFF;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <?php
    // Function to generate a grid item for a product
    function generateGridItem($product, $idRange)
    {
        // Check if the product ID is within the specified range
        if ($product['id'] >= $idRange[0] && $product['id'] <= $idRange[1]) {
            echo '<div class="grid-item">';
            echo '<img class="product-image" src="../pictures/' . $product['id'] . '.jpg" alt="' . $product['id'] . '">';
            echo '<h3>name: ' . $product['model'] . '</h3>';
            echo '<h3>type: ' . $product['type'] . '</h3>';
            echo '<h3>price/day: ' . $product['rental_price'] . ' $</h3>';
            if ($product['quantity'] > 0) {
                echo '<h3>Available</h3>';
                echo '<button class="rent-button" onClick="goToRent(\'' . $product['id'] . '\', ' . $product['quantity'] . ')">Rent</button>';
            } else {
                echo '<h3>Not Available</h3>';
                echo '<button class="rent-button" disabled>Rent</button>';
            }
            echo '</div>';
        }
    }

    // Load product data from JSON file
    $jsonData = file_get_contents('../json/cars.json');
    $products = json_decode($jsonData, true);

    echo '<div class="grid-container">';
    // Check if the 'info' parameter is set in the URL
    if (isset($_GET['info'])) {
        $fruitId = $_GET['info'];
        // Set the ID range based on the 'info' parameter value
        switch ($fruitId) {
            case 'cars_info_1':
                $idRange = [6, 10];
                break;
            case 'cars_info_2':
                $idRange = [21, 25];
                break;
            case 'cars_info_3':
                $idRange = [41, 45];
                break;
            case 'cars_info_4':
                $idRange = [11, 15];
                break;
            case 'cars_info_5':
                $idRange = [16, 20];
                break;
            case 'cars_info_6':
                $idRange = [36, 40];
                break;
            case 'cars_info_7':
                $idRange = [1, 5];
                break;
            case 'cars_info_8':
                $idRange = [26, 30];
                break;
            case 'cars_info_9':
                $idRange = [31, 35];
                break;
            default:
                $idRange = [0, 0]; // Invalid ID range
        }

        // Generate grid items for products within the specified ID range
        foreach ($products as $product) {
            generateGridItem($product, $idRange);
        }
    } else {
        // Display the cover page
        echo '<div class="page-container">';
        echo '<img class="page-image" src="../pictures/cover.webp">';
        echo '<p class="text">Choose Your Motor Now</p>';
        echo '</div>';
    }
    echo '</div>';
    ?>

    <script>
        // Function to handle the "Rent" button click
        function goToRent(id, number) {
            console.log(number);
            var valueToPass = id;

            // Send an AJAX request to check for uncompleted orders
            var xhrCheck = new XMLHttpRequest();
            xhrCheck.open('GET', '../controller/check_uncompleted.php', true);
            xhrCheck.onreadystatechange = function() {
                if (xhrCheck.readyState === XMLHttpRequest.DONE && xhrCheck.status === 200) {
                    console.log("Check uncompleted response:", xhrCheck.responseText);

                    if (number > 0) {
                        console.log("....................");
                        // Send the first AJAX request to save the uncompleted order
                        var xhr1 = new XMLHttpRequest();
                        xhr1.open('POST', '../controller/save_uncompleted.php', true);
                        xhr1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        xhr1.onreadystatechange = function() {
                            if (xhr1.readyState === XMLHttpRequest.DONE && xhr1.status === 200) {
                                console.log(xhr1.responseText);

                                // Send the second AJAX request to update the product quantity
                                var xhr2 = new XMLHttpRequest();
                                xhr2.open('POST', '../controller/update_quantity.php', true);
                                xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                xhr2.onreadystatechange = function() {
                                    if (xhr2.readyState === XMLHttpRequest.DONE && xhr2.status === 200) {
                                        console.log(xhr2.responseText);
                                        // Redirect to the cart page with the selected product ID
                                        parent.parent.document.getElementById("indexPanel").src = "../page/cart.php?carId=" + valueToPass;
                                    }
                                };

                                var data2 = 'id=' + encodeURIComponent(id) + '&quantity=' + encodeURIComponent(1);
                                xhr2.send(data2);
                            }
                        };

                        var data1 = 'id=' + encodeURIComponent(id) + '&quantity=' + encodeURIComponent(1);
                        xhr1.send(data1);
                    } else {
                        alert("the number is not enough");
                    }
                }
            };
            xhrCheck.send();
        }
    </script>

</body>

</html>