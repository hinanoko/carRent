<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* 整体样式 */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            border-radius: 10px;
            /* 头部容器圆角 */
        }

        /* 头部样式 */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: hsl(158, 71%, 28%);
            color: #fff;
            border-radius: 10px;
            /* 头部容器圆角 */
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .store-name h1 {
            font-family: 'Righteous', cursive;
            font-size: 36px;
            margin: 0;
        }

        /* 车辆详情样式 */
        .car-details {
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            margin: 20px;
        }

        .car-details h3 {
            margin-top: 0;
        }

        .car-details img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }

        /* 表单样式 */
        #rentalForm {
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            margin: 20px;
        }

        #rentalForm label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        #rentalForm input,
        #rentalForm select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        #quantityContainer {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        #quantityContainer button {
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #quantityDisplay {
            margin: 0 10px;
            font-size: 16px;
        }

        #rentalForm button[type="button"] {
            padding: 8px 16px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .back-button {
            background-color: #4CAF50;
            /* 绿色 */
            border: none;
            color: white;
            padding: 10px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #3e8e41;
            /* 深绿色 */
        }
    </style>
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
            // 处理没有找到匹配的车辆数据的情况
            echo "<p>No car found with the provided ID.</p>";
        }
    } else {
        // 处理 id.json 文件没有内容的情况
        echo "<p>The Reservation List is empty, choose the car now.</p>";
        echo "<button class='back-button' onclick='backToMain()'>Back to Main Page</button>";
    }
    ?>
    <script>
        let currentQuantity = <?php echo $quantity; ?>;

        function updateTotalPrice() {
            let rentalPrice = <?php echo $selectedCar['rental_price']; ?>;
            let quantity = parseInt(document.getElementById('quantityDisplay').innerText);
            let startDate = new Date(document.getElementById('startDate').value);
            let endDate = new Date(document.getElementById('endDate').value);

            if (!isNaN(startDate) && !isNaN(endDate) && endDate > startDate) {
                let timeDifference = endDate.getTime() - startDate.getTime();
                let daysDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));
                let totalPrice = rentalPrice * quantity * daysDifference;
                document.getElementById("totalPrice").innerText = `$${totalPrice}`;
            } else {
                document.getElementById("totalPrice").innerText = `$${rentalPrice * quantity}`;
            }
        }

        function decreaseTheQuan(id) {
            if (currentQuantity === 1) {
                console.log("5555555555")
                updateTotalPrice();
                return;
            }
            console.log("-" + id);
            $.ajax({
                type: 'POST',
                url: '../controller/decrease_cart.php',
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
            $.ajax({
                type: 'POST',
                url: '../controller/increase_quantity.php',
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
            currentQuantity--;
            document.getElementById('quantityDisplay').textContent = currentQuantity;
            updateTotalPrice();
        }

        function increaseTheQuan(id) {
            console.log("+" + id);
            $.ajax({
                type: 'GET',
                url: '../controller/get_quantity.php',
                data: {
                    carId: id
                },
                success: function(response) {
                    console.log(response);
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
                                console.log(response);
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
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
                        updateTotalPrice();
                    } else {
                        console.log("?");
                        alert("the store don't have enough car")
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
                    console.log(response);
                },
                error: function(error) {
                    console.error(error);
                }
            });

            $.ajax({
                type: 'POST',
                url: '../controller/backToCart.php',
                data: {
                    id: id,
                    quantity: currentQuantity
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error(error);
                }
            });
            window.location.reload();
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
            const formError = document.getElementById('formError');

            // 清除之前的错误消息
            dateError.textContent = '';
            nameError.textContent = '';
            mobileError.textContent = '';
            emailError.textContent = '';
            licenseError.textContent = '';
            formError.textContent = '';

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

            // 如果表单数据有效,则检查 uncompleted.json 文件中的 quantity
            if (isValid) {
                $.ajax({
                    type: 'GET',
                    url: '../controller/check_quantity.php',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response)
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
    </script>
</body>

</html>