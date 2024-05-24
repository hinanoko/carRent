<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div>
        <p>this is the confirm page</p>
        <img src="../pictures/confirm.jpg"></img>
    </div>
    <?php
    // page/cart.php

    // 接收传递的参数
    if (isset($_GET['param'])) {
        $paramValue = $_GET['param'];
        // 处理接收到的参数值
        echo '接收到的参数值：' . $paramValue;
    } else {
        echo '未接收到参数值';
    }

    ?>
</body>

</html>