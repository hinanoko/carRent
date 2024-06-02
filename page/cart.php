<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../style/cart.css">
</head>

<body>
    <script>
        function backToMain() {
            parent.parent.document.getElementById("indexPanel").src = "../main.html";
        }
        // 手机号验证函数
        function validateMobile() {
            const mobileInput = document.getElementById('mobile');
            const mobileError = document.getElementById('mobileError');
            const mobileRegex = /^[0-9]{10}$/;

            if (mobileRegex.test(mobileInput.value)) {
                mobileError.textContent = 'you are right';
                mobileError.style.color = 'green'; // Set text color to green
            } else {
                mobileError.textContent = 'Invalid mobile number';
                mobileError.style.color = 'red'; // Set text color to green
            }
        }

        // 电子邮件验证函数
        function validateEmail() {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

            if (emailRegex.test(emailInput.value)) {
                emailError.textContent = 'you are right';
                emailError.style.color = 'green'; // Set text color to green
            } else {
                emailError.textContent = 'Invalid email address';
                emailError.style.color = 'red'; // Set text color to green
            }
        }
    </script>
    <div class="header-container">
        <div class="header-left">
            <img src="../pictures/logo.png" alt="Logo" class="header-icon">
            <div class="store-name">
                <h1>Motor Rent Reservation</h1>
            </div>
        </div>
    </div>

    <?php
    // Read the id.json file
    $id_json_data = file_get_contents('../json/uncompleted.json');
    $id_data = json_decode($id_json_data, true);

    // initialize variable
    $carId = isset($id_data['id']) ? $id_data['id'] : null;
    $quantity = isset($id_data['quantity']) ? $id_data['quantity'] : 1;

    // Check if there is content in the id.json file
    if ($carId !== null) {

        // Read the cars.json file
        $json_data = file_get_contents('../json/cars.json');
        $cars = json_decode($json_data, true);

        // Find matching vehicle data
        $selectedCar = null;
        foreach ($cars as $car) {
            if ($car['id'] === $carId) {
                $selectedCar = $car;
                break;
            }
        }

        // If matching vehicle data is found
        if ($selectedCar !== null) {
            // Output vehicle data
            echo '<div class="car-details">';
            echo '<h3>' . $selectedCar['make'] . ' ' . $selectedCar['model'] . '</h3>';
            echo '<img src="../pictures/' . $selectedCar['id'] . '.jpg" alt="' . $selectedCar['model'] . '" width="200">';
            echo '<p>Year: ' . $selectedCar['year'] . '</p>';
            echo '<p>Seats: ' . $selectedCar['seats'] . '</p>';
            echo '<p>Fuel Type: ' . $selectedCar['fuel_type'] . '</p>';
            echo '<p>Mileage: ' . $selectedCar['mileage'] . '</p>';
            echo '<p>Rental Price: $' . $selectedCar['rental_price'] . '</p>';
            echo '<p>' . $selectedCar['description'] . '</p>';
            echo '</div>';
    ?>

            <div>
                <form id="rentalForm">
                    <label for="quantity">Quantity:</label>
                    <div id="quantityContainer">
                        <button type="button" onclick="decreaseTheQuan('<?php echo $selectedCar['id']; ?>')">-</button>
                        <span id="quantityDisplay"><?php echo $quantity; ?></span>
                        <button type="button" onclick="increaseTheQuan('<?php echo $selectedCar['id']; ?>')">+</button>
                    </div>
                    <br>
                    <label for="totalPrice">Total Price:</label>
                    <span id="totalPrice">$<?php echo $selectedCar['rental_price'] * $quantity; ?></span>
                    <br>
                    <label for="startDate">Start Date:</label>
                    <input type="date" id="startDate" name="startDate" onchange="updateTotalPrice()" required>
                    <br>
                    <label for="endDate">End Date:</label>
                    <input type="date" id="endDate" name="endDate" onchange="updateTotalPrice()" required>
                    <span class="error" id="dateError"></span>
                    <br>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="please input your name" required>
                    <span class="error" id="nameError"></span>
                    <br>
                    <label for="mobile">Mobile Number:</label>
                    <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" placeholder="10 numbers, like: 0478123456" required onkeyup="validateMobile()">
                    <span class="error" id="mobileError"></span>
                    <br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="email format, like: xxx.xxx@gmail.com" required onkeyup="validateEmail()">
                    <span class="error" id="emailError"></span>
                    <br>
                    <label for="license">Valid Driver's License:</label>
                    <select id="license" name="license" required>
                        <option value="">Select</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                    <span class="error" id="licenseError"></span>
                    <br>
                    <button type="button" onclick="submitTheInfo('<?php echo $selectedCar['id']; ?>')">Submit Rental Order</button>
                    <button type="button" onclick="cancelOrder('<?php echo $selectedCar['id']; ?>')">Cancel</button>
                    <span class="error" id="formError"></span>
                </form>
                <button class='back-button' onclick="backToMain()">backToMain</button>
            </div>
    <?php
        } else {
            // Dealing with situations where no matching vehicle data is found
            echo "<p>No car found with the provided ID.</p>";
        }
    } else {
        // Dealing with situations where the id.json file has no content
        echo "<p>The Reservation List is empty, choose the car now.</p>";
        echo "<button class='back-button' onclick='backToMain()'>Back to Main Page</button>";
    }
    ?>
    <script>
        let currentQuantity = <?php echo $quantity; ?>;

        function updateTotalPrice() {
            // Get rental price, quantity, and selected dates
            let rentalPrice = <?php echo $selectedCar['rental_price']; ?>;
            let quantity = parseInt(document.getElementById('quantityDisplay').innerText);
            let startDate = new Date(document.getElementById('startDate').value);
            let endDate = new Date(document.getElementById('endDate').value);

            // Calculate total price if selected dates are valid
            if (!isNaN(startDate) && !isNaN(endDate) && endDate > startDate) {
                // Calculate time difference and days difference
                let timeDifference = endDate.getTime() - startDate.getTime();
                let daysDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));

                // Calculate total price based on rental duration, quantity, and rental price
                let totalPrice = rentalPrice * quantity * daysDifference;
                document.getElementById("totalPrice").innerText = `$${totalPrice}`;
            } else {
                // Calculate total price without considering rental duration
                document.getElementById("totalPrice").innerText = `$${rentalPrice * quantity}`;
            }
        }

        function decreaseTheQuan(id) {
            // Check if the current quantity is 1
            if (currentQuantity === 1) {
                console.log("5555555555"); // Log a message for debugging
                updateTotalPrice(); // Update the total price when quantity is decreased to 1
                return; // Exit the function
            }

            console.log("-" + id); // Log the ID for debugging purposes

            // Decrease the quantity by sending an AJAX request to decrease_cart.php
            $.ajax({
                type: 'POST',
                url: '../controller/decrease_cart.php',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response); // Log the response for debugging
                },
                error: function(error) {
                    console.error(error); // Log any errors encountered
                }
            });

            // Increase the quantity by sending an AJAX request to increase_quantity.php
            $.ajax({
                type: 'POST',
                url: '../controller/increase_quantity.php',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response); // Log the response for debugging
                },
                error: function(error) {
                    console.error(error); // Log any errors encountered
                }
            });

            // Decrease the current quantity in the UI
            currentQuantity--;
            document.getElementById('quantityDisplay').textContent = currentQuantity;

            // Update the total price after changing the quantity
            updateTotalPrice();
        }

        function increaseTheQuan(id) {
            console.log("+" + id); // Log the ID for debugging

            // Send a GET request to get the current quantity
            $.ajax({
                type: 'GET',
                url: '../controller/get_quantity.php',
                data: {
                    carId: id
                },
                success: function(response) {
                    console.log(response); // Log the response for debugging

                    // Check if the quantity is available
                    if (response > 0) {
                        currentQuantity++; // Increase the current quantity
                        document.getElementById('quantityDisplay').textContent = currentQuantity; // Update the quantity display in UI

                        // Send a POST request to increase_cart.php to update the cart
                        $.ajax({
                            type: 'POST',
                            url: '../controller/increase_cart.php',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                console.log(response); // Log the response for debugging
                            },
                            error: function(error) {
                                console.error(error); // Log any errors encountered
                            }
                        });

                        // Send a POST request to update_quantity.php to update the quantity
                        $.ajax({
                            type: 'POST',
                            url: '../controller/update_quantity.php',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                console.log(response); // Log the response for debugging
                            },
                            error: function(error) {
                                console.error(error); // Log any errors encountered
                            }
                        });

                        // Update the total price after changing the quantity
                        updateTotalPrice();
                    } else {
                        console.log("?"); // Log a question mark for debugging
                        alert("the store don't have enough car"); // Show an alert if the car is not available
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error); // Log any errors encountered
                }
            });
        }

        function cancelOrder(id) {
            console.log("Welcome, your id is: " + id); // Log a welcome message with the ID

            // Send a POST request to delete_uncompleted.php to cancel the order
            $.ajax({
                type: 'POST',
                url: '../controller/delete_uncompleted.php',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response); // Log the response for debugging
                },
                error: function(error) {
                    console.error(error); // Log any errors encountered
                }
            });

            // Send a POST request to backToCart.php to update the cart
            $.ajax({
                type: 'POST',
                url: '../controller/backToCart.php',
                data: {
                    id: id,
                    quantity: currentQuantity
                },
                success: function(response) {
                    console.log(response); // Log the response for debugging
                },
                error: function(error) {
                    console.error(error); // Log any errors encountered
                }
            });

            window.location.reload(); // Reload the window after canceling the order
        }


        function submitTheInfo(id) {
            // Get form data
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const name = document.getElementById('name').value;
            const mobile = document.getElementById('mobile').value;
            const email = document.getElementById('email').value;
            const license = document.getElementById('license').value;
            const totalPrice = document.getElementById('totalPrice').value;
            console.log(totalPrice);

            // Perform form validation
            let isValid = true;
            const dateError = document.getElementById('dateError');
            const nameError = document.getElementById('nameError');
            const mobileError = document.getElementById('mobileError');
            const emailError = document.getElementById('emailError');
            const licenseError = document.getElementById('licenseError');
            const formError = document.getElementById('formError');

            // Clear previous error messages
            dateError.textContent = '';
            nameError.textContent = '';
            mobileError.textContent = '';
            emailError.textContent = '';
            licenseError.textContent = '';
            formError.textContent = '';

            // Validate date range
            if (startDate >= endDate) {
                dateError.textContent = 'End date must be after start date';
                isValid = false;
            }

            // Validate name
            if (name.trim() === '') {
                nameError.textContent = 'Name is required';
                isValid = false;
            }

            // Validate mobile number
            const mobileRegex = /^[0-9]{10}$/;
            if (!mobileRegex.test(mobile)) {
                mobileError.textContent = 'Invalid mobile number';
                isValid = false;
            }

            // Validate email address
            const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
            if (!emailRegex.test(email)) {
                emailError.textContent = 'Invalid email address';
                isValid = false;
            }

            // Validate driver's license
            if (license === '') {
                licenseError.textContent = 'Please select an option';
                isValid = false;
            }

            // If form data is valid, check the quantity in uncompleted.json file
            if (isValid) {
                $.ajax({
                    type: 'GET',
                    url: '../controller/check_quantity.php',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response > 0) {
                            processOrder(id, startDate, endDate, name, mobile, email, license);
                        } else {
                            formError.textContent = 'The selected car is not available for rent.';
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        }

        function processOrder(id, startDate, endDate, name, mobile, email, license) {
            // Get selected car details and calculate total price
            const selectedCar = <?php echo json_encode($selectedCar); ?>;
            const rentalPrice = selectedCar.rental_price;
            const startDateTime = new Date(startDate);
            const endDateTime = new Date(endDate);
            const diffDays = Math.ceil((endDateTime - startDateTime) / (1000 * 60 * 60 * 24));
            const totalPrice = diffDays * currentQuantity * rentalPrice;

            // Prepare form data for submission
            const formData = {
                startDate,
                endDate,
                name,
                mobile,
                email,
                license,
                quantity: currentQuantity,
                carId: id,
                totalPrice: totalPrice,
                status: "pending"
            };

            // Delete uncompleted order
            $.ajax({
                type: 'POST',
                url: '../controller/delete_uncompleted.php',
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

            // Process the order
            $.ajax({
                type: 'POST',
                url: '../controller/process_order.php',
                data: formData,
                success: function(response) {
                    console.log(response);
                    // Handle server response
                    var param = id; // Replace with the parameter you want to pass
                    parent.parent.document.getElementById("indexPanel").src = "../page/confirm.php?param=" + encodeURIComponent(param);
                },
                error: function(error) {
                    console.error(error);
                    // Handle errors
                }
            });
        }
    </script>
</body>

</html>