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
            height: 150px;
        }

        .page-container {
            text-align: center;
            margin-top: 20px;
        }

        .page-image {
            width: 800px;
            height: 550px;
        }

        .text {
            margin-top: 20px;
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

        .rent-button:disabled {
            background-color: #ccc;
            color: #666;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <?php
    function generateGridItem($product, $idRange)
    {
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

    $jsonData = file_get_contents('../json/cars.json');
    $products = json_decode($jsonData, true);

    echo '<div class="grid-container">';
    if (isset($_GET['info'])) {
        $fruitId = $_GET['info'];
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
                $idRange = [0, 0]; // 无效的ID范围
        }

        foreach ($products as $product) {
            generateGridItem($product, $idRange);
        }
    } else {
        echo '<div class="page-container">';
        echo '<img class="page-image" src="../pictures/cover.webp">';
        echo '<p class="text">Choose Your Motor Now</p>';
        echo '</div>';
    }
    echo '</div>';
    ?>

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