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
    if ($carId !== null) {

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
            // 输出车辆数据
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
                <h3>Edit Rental Details</h3>
                <form id="rentalForm" action="order.php" method="post">
                    <label for="quantity">Quantity:</label>
                    <div id="quantityContainer">
                        <button type="button" onclick="decreaseTheQuan('<?php echo $selectedCar['id']; ?>')">-</button>
                        <span id="quantityDisplay"><?php echo $quantity; ?></span>
                        <button type="button" onclick="increaseTheQuan('<?php echo $selectedCar['id']; ?>')">+</button>
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
                    <button onclick="submitTheInfo('<?php echo $selectedCar['id']; ?>')">Submit Rental Order</button>
                    <button type="button" onclick="cancelOrder('<?php echo $selectedCar['id']; ?>')">Cancel</button>
                    <span class="error" id="formError"></span>
                </form>
            </div>
    <?php
        } else {
            // 处理没有找到匹配的车辆数据的情况
            echo "No car found with the provided ID.";
        }
    } else {
        // 处理 id.json 文件没有内容的情况
        echo "No ID provided in the JSON file.";
    }
    ?>
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
            $.ajax({
                type: 'POST',
                url: '../controller/delete_uncompleted.php',
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
                url: '../controller/backToCart.php',
                data: {
                    id: id,
                    quantity: currentQuantity
                },
                success: function(response) {
                    console.log(response)
                },
                error: function(error) {
                    console.error(error)
                }
            })
            window.location.reload()
        }


        function submitTheInfo(id) {
            // 获取表单数据
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const name = document.getElementById('name').value;
            const mobile = document.getElementById('mobile').value;
            const email = document.getElementById('email').value;
            const license = document.getElementById('license').value;

            // 执行表单验证
            let isValid = true;
            const dateError = document.getElementById('dateError');
            const nameError = document.getElementById('nameError');
            const mobileError = document.getElementById('mobileError');
            const emailError = document.getElementById('emailError');
            const licenseError = document.getElementById('licenseError');

            // 清除之前的错误消息
            dateError.textContent = '';
            nameError.textContent = '';
            mobileError.textContent = '';
            emailError.textContent = '';
            licenseError.textContent = '';

            // 验证日期范围
            if (startDate >= endDate) {
                dateError.textContent = 'End date must be after start date';
                isValid = false;
            }

            // 验证姓名
            if (name.trim() === '') {
                nameError.textContent = 'Name is required';
                isValid = false;
            }

            // 验证手机号码
            const mobileRegex = /^[0-9]{10}$/;
            if (!mobileRegex.test(mobile)) {
                mobileError.textContent = 'Invalid mobile number';
                isValid = false;
            }

            // 验证电子邮件
            const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
            if (!emailRegex.test(email)) {
                emailError.textContent = 'Invalid email address';
                isValid = false;
            }

            // 验证驾驶执照
            if (license === '') {
                licenseError.textContent = 'Please select an option';
                isValid = false;
            }

            // 如果表单数据有效,则发送到服务器
            if (isValid) {
                console.log("....................")
                const selectedCar = <?php echo json_encode($selectedCar); ?>;
                const rentalPrice = selectedCar.rental_price;
                const startDateTime = new Date(startDate);
                const endDateTime = new Date(endDate);
                const diffDays = Math.ceil((endDateTime - startDateTime) / (1000 * 60 * 60 * 24));
                const totalPrice = diffDays * currentQuantity * rentalPrice;
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

                $.ajax({
                    type: 'POST',
                    url: '../controller/delete_uncompleted.php',
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
                    url: '../controller/process_order.php',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        // 处理服务器响应
                        var param = id; // 替换为您要传递的参数值
                        parent.parent.document.getElementById("indexPanel").src = "../page/confirm.php?param=" + encodeURIComponent(param);
                    },
                    error: function(error) {
                        console.error(error);
                        // 处理错误
                    }
                });
            }
        }
    </script>
</body>

</html>