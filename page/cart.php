<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <?php
    // 读取 id.json 文件
    $id_json_data = file_get_contents('../json/uncompleted.json');
    $id_data = json_decode($id_json_data, true);

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
        <form id="rentalForm">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1" required>
            <br>
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate" required>
            <br>
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate" required>
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
            <label for="license">Valid Driver’s License:</label>
            <select id="license" name="license" required>
                <option value="">Select</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <span class="error" id="licenseError"></span>
            <br>
            <button id="goToOrder" type="submit">Submit Rental Order</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            // 当按钮被点击时
            $('#goToOrder').click(function() {
                // 发送 AJAX 请求
                $.ajax({
                    //url: 'page/order.php',
                    success: function(response) {
                        var valueToPass = 'I am cart';
                        window.location.href = 'order.php?param=' + encodeURIComponent(valueToPass);
                    }
                });
            });
        });
    </script>
</body>

</html>