<!DOCTYPE html>
<html>

<head>
    <script>
        function increaseTheQuan(id) {
            console.log("+" + id);
            // Send an AJAX GET request to get the current quantity of the car
            $.ajax({
                type: 'GET',
                url: '../controller/get_quantity.php',
                data: {
                    carId: id
                },
                success: function(response) {
                    console.log(response);
                    // Check if the response quantity is greater than 0
                    if (response > 0) {
                        currentQuantity++;
                        // Update the quantity display on the page
                        document.getElementById('quantityDisplay').textContent = currentQuantity;
                        // Send an AJAX POST request to increase the quantity in the cart
                        $.ajax({
                            type: 'POST',
                            url: '../controller/increase_cart.php',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                console.log(response);
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                        // Send an AJAX POST request to update the quantity in the inventory
                        $.ajax({
                            type: 'POST',
                            url: '../controller/update_quantity.php',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                console.log(response);
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    } else {
                        console.log("?");
                        alert("The store doesn't have enough cars available")
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
</head>

<body>
    <?php
    // Start the session
    session_start();
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $info = $_POST['info'];
        // Display the received data
        echo "<div>Data is: " . $info . "</div>";
        // Store the received data in the session
        $_SESSION['info'] = $info;
    } else {
        echo "Error: Invalid request method";
    }
    ?>
    <!-- Display the info from the session if it exists -->
    <div>
        <?php
        // Check if 'info' is set in the session and display it
        if (isset($_SESSION['info'])) {
            echo "Info from session: " . $_SESSION['info'];
        }
        ?>
    </div>
</body>

</html>