<html>

<head>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            /* 禁止水平滚动 */
        }

        /* 添加样式以便按钮在页面最右侧固定位置 */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        .header-button {
            margin: 0 10px;
            padding: 15px 20px 10px 22px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: hsl(158, 71%, 28%);
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: background-color 0.3s ease;
            background-repeat: no-repeat;
            background-position: center bottom 15px;
            background-size: 50px;
        }

        .header-button:hover {
            background-color: #0056b3;
        }

        .store-name {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .store-name h1 {
            font-family: 'Righteous', cursive;
            font-size: 36px;
        }

        .car-button {
            background-image: url('../icons/transparent_car.png');
            padding-top: 30px;
        }
    </style>
</head>

<body>
    <div class="header-container">
        <div class="store-name">
            <h1>Motor Rent Store</h1>
        </div>
        <div class="header-right">
            <button class="header-button car-button" onclick="goToCart()">Reservation</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function goToCart() {
            var valueToPass = 'anything';
            parent.parent.document.getElementById("indexPanel").src = "../page/cart.php?carId=" + valueToPass;
        }
    </script>
</body>

</html>