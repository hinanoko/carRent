<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <?php
    // 读取 id.json 文件
    $id_json_data = file_get_contents('../json/uncompleted.json');
    $id_data = json_decode($id_json_data, true);

    // 初始化变量
    $carId = isset($id_data['id']) ? $id_data['id'] : null;
    $quantity = isset($id_data['quantity']) ? $id_data['quantity'] : 1;
    // 检查 id.json 文件是否有内容
    if (isset($id_data['id'])) {
        $carId = $id_data['id'];

        // 读取 cars.json 文件
        $json_data = file_get_contents('../json/cars.json');
        $cars = json_decode($json_data, true);

        // 查找匹配的车辆数据
        $selectedCar = null;
        foreach ($cars as $car) {
            if ($car['id'] === $carId) {
                $selectedCar = $car;
                break;
            }
        }

        // 如果找到匹配的车辆数据
        if ($selectedCar !== null) {
            // 渲染车辆数据
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
        } else {
            // 处理没有找到匹配的车辆数据的情况
            echo "No car found with the provided ID.";
        }
    } else {
        // 处理 id.json 文件没有内容的情况
        echo "No ID provided in the JSON file.";
    }
    ?>
    <div>
        <h3>Edit Rental Details</h3>
        <form id="rentalForm" action="order.php" method="post">
            <label for="quantity">Quantity:</label>
            <div id="quantityContainer">
                <button onclick="decreaseTheQuan('<?php echo $selectedCar['id']; ?>')">-</button>
                <span id="quantityDisplay"><?php echo $quantity; ?></span>
                <button onclick="increaseTheQuan('<?php echo $selectedCar['id']; ?>')">+</button>
            </div>
            <br>
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate" required>
            <br>
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate" required>
            <span class="error" id="dateError"></span>
            <br>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <span class="error" id="nameError"></span>
            <br>
            <label for="mobile">Mobile Number:</label>
            <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" required>
            <span class="error" id="mobileError"></span>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
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
            <button id="goToOrder" type="submit">Submit Rental Order</button>
            <button type="button" onclick="cancelOrder('<?php echo $selectedCar['id']; ?>')">Cancel</button>
            <span class="error" id="formError"></span>
        </form>
    </div>
    <style>
        #quantityContainer {
            display: flex;
            align-items: center;
        }

        #quantityContainer button {
            padding: 5px 10px;
            font-size: 16px;
        }

        #quantityDisplay {
            margin: 0 10px;
            font-size: 16px;
        }
    </style>
    <script>
        let currentQuantity = <?php echo $quantity; ?>;

        function decreaseTheQuan(id) {
            if (currentQuantity === 1) {
                return
            }
            console.log("-" + id)
            $.ajax({
                type: 'POST',
                url: '../controller/decrease_cart.php',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response)
                },
                error: function(error) {
                    console.error(error)
                }
            })
            $.ajax({
                type: 'POST',
                url: '../controller/increase_quantity.php',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response)
                },
                error: function(error) {
                    console.error(error)
                }
            })
            currentQuantity--;
            document.getElementById('quantityDisplay').textContent = currentQuantity;
        }

        function increaseTheQuan(id) {
            console.log("+" + id)
            $.ajax({
                type: 'GET',
                url: '../controller/get_quantity.php',
                data: {
                    carId: id
                },
                success: function(response) {
                    console.log(response)
                    if (response > 0) {
                        currentQuantity++;
                        document.getElementById('quantityDisplay').textContent = currentQuantity;
                        $.ajax({
                            type: 'POST',
                            url: '../controller/increase_cart.php',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                console.log(response)
                            },
                            error: function(error) {
                                console.error(error)
                            }
                        })
                        $.ajax({
                            type: 'POST',
                            url: '../controller/update_quantity.php',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                console.log(response)
                            },
                            error: function(error) {
                                console.error(error)
                            }
                        })
                    } else {
                        console.log("?")
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function cancelOrder(id) {
            console.log("Welcome, your id is: " + id);
        }

        const form = document.getElementById('rentalForm');
        const submitButton = document.getElementById('goToOrder');
        const formError = document.getElementById('formError');
        const dateError = document.getElementById('dateError');

        submitButton.addEventListener('click', function(event) {
            event.preventDefault(); // 防止表单默认提交

            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const name = document.getElementById('name').value;
            const mobile = document.getElementById('mobile').value;
            const email = document.getElementById('email').value;
            const license = document.getElementById('license').value;
            const carId = <?php echo $selectedCar['id']; ?>;
            const quantity = currentQuantity;

            // 检查结束日期是否晚于开始日期
            if (endDate < startDate) {
                dateError.textContent = 'End date must be after start date.';
            } else {
                dateError.textContent = '';

                // 检查所有字段是否都填写了
                if (quantity && startDate && endDate && name && mobile && email && license) {
                    // 检查驾照选项是否为"Yes"
                    if (license === 'yes') {
                        const startDateObj = new Date(startDate);
                        const endDateObj = new Date(endDate);
                        const timeDiff = endDateObj.getTime() - startDateObj.getTime();
                        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                        const totalPrice = daysDiff * quantity * <?php echo $selectedCar['rental_price']; ?>;

                        // 所有验证通过,可以发送 AJAX 请求
                        const formData = {
                            quantity: quantity,
                            startDate: startDate,
                            endDate: endDate,
                            name: name,
                            mobile: mobile,
                            email: email,
                            license: license,
                            carId: carId,
                            totalPrice: totalPrice
                        };

                        $.ajax({
                            type: 'POST',
                            url: '../controller/process_order.php',
                            data: formData,
                            success: function(response) {
                                console.log(response);
                                $.ajax({
                                    type: 'POST',
                                    url: '../controller/delete_uncompleted.php',
                                    success: function(deleteResponse) {
                                        console.log(deleteResponse);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                                var valueToPass = 'I am order';
                                window.location.href = 'confirm.php?param=' + encodeURIComponent(valueToPass);
                                // 处理成功响应
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                                // 处理错误响应
                            }
                        });
                    } else {
                        formError.textContent = 'You must have a valid driver\'s license to submit the rental order.';
                    }
                } else {
                    formError.textContent = 'Please fill in all fields before submitting the rental order.';
                }
            }
        });
    </script>
</body>

</html>