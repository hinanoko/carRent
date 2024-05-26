<!DOCTYPE html>
<html>

<head>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            border-radius: 8px;
        }

        .grid-item {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            background-color: cadetblue;
        }

        .product-image {
            width: 200px;
            /* 设置固定宽度 */
            height: 150px;
        }

        .text {
            margin-top: 20px;
            /* 确保文字不紧贴图片 */
            font-size: 24px;
            font-family: Arial, sans-serif;
        }

        .grid-item:hover {
            background-color: #ccc;
        }

        .rent-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="grid-container">
        <?php
        if (isset($_GET['results'])) {
            $results = json_decode($_GET['results'], true);

            foreach ($results as $product) {
                echo '<div class="grid-item">';
                echo '<img class="product-image" src="../pictures/' . $product['id'] . '.jpg" alt="' . $product['id'] . '">';
                echo '<h3>' . $product['model'] . '</h3>';
                echo '<h3>' . $product['type'] . '</h3>';
                echo '<h3>' . $product['rental_price'] . '</h3>';
                if ($product['quantity'] > 0) {
                    echo '<h3>Available</h3>';
                } else {
                    echo '<h3>Not Available</h3>';
                }
                echo '<button class="rent-button" onClick="goToRent(\'' . $product['id'] . '\', ' . $product['quantity'] . ')">Rent</button>';
                echo '</div>';
            }
        } else {
            echo '<div class="text">No search results to display.</div>';
        }
        ?>
    </div>

    <script>
        function goToRent(id, number) {
            console.log(number);
            var valueToPass = id;

            var xhrCheck = new XMLHttpRequest();
            xhrCheck.open('GET', '../controller/check_uncompleted.php', true);
            xhrCheck.onreadystatechange = function() {
                if (xhrCheck.readyState === XMLHttpRequest.DONE && xhrCheck.status === 200) {
                    console.log("Check uncompleted response:", xhrCheck.responseText);

                    if (number > 0) {
                        console.log("....................");
                        // 发送第一个 AJAX 请求
                        var xhr1 = new XMLHttpRequest();
                        xhr1.open('POST', '../controller/save_uncompleted.php', true);
                        xhr1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        xhr1.onreadystatechange = function() {
                            if (xhr1.readyState === XMLHttpRequest.DONE && xhr1.status === 200) {
                                console.log(xhr1.responseText);

                                // 发送第二个 AJAX 请求
                                var xhr2 = new XMLHttpRequest();
                                xhr2.open('POST', '../controller/update_quantity.php', true);
                                xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                xhr2.onreadystatechange = function() {
                                    if (xhr2.readyState === XMLHttpRequest.DONE && xhr2.status === 200) {
                                        console.log(xhr2.responseText);
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