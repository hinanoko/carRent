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
    // Check if the 'results' parameter is set in the URL
    if (isset($_GET['results'])) {
        // Decode the JSON data from the 'results' parameter
        $results = json_decode($_GET['results'], true);
        // Check if the results are random (count is 5 and 'query' parameter is not set)
        $isRandomResults = count($results) === 5 && !isset($_GET['query']);
    ?>
        <?php if ($isRandomResults) : ?>
            <!-- Display a message for random recommended options -->
            <div class="text">No matching options, here are 5 recommended options:</div>
        <?php endif; ?>
        <!-- Grid container for displaying search results -->
        <div class="grid-container">
            <?php
            // Loop through the search results
            foreach ($results as $product) {
                echo '<div class="grid-item">';
                echo '<img class="product-image" src="../pictures/' . $product['id'] . '.jpg" alt="' . $product['id'] . '">';
                echo '<h3>name: ' . $product['model'] . '</h3>';
                echo '<h3>type: ' . $product['type'] . '</h3>';
                echo '<h3>price/day: ' . $product['rental_price'] . '</h3>';
                if ($product['quantity'] > 0) {
                    echo '<h3>Available</h3>';
                    echo '<button class="rent-button" onClick="goToRent(\'' . $product['id'] . '\', ' . $product['quantity'] . ')">Rent</button>';
                } else {
                    echo '<h3>Not Available</h3>';
                    echo '<button class="rent-button" disabled>Rent</button>';
                }
                echo '</div>';
            }
            ?>
        </div>
    <?php
    } else {
        // Display a message when there are no search results
        echo '<div class="text">No search results to display.</div>';
    }
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