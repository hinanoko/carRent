<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
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
    <div>
        <p>this is the order page</p>
        <button id="goToConfirm">go to confirm</button>
    </div>

    <script>
        $(document).ready(function() {
            // 当按钮被点击时
            $('#goToConfirm').click(function() {
                // 发送 AJAX 请求
                $.ajax({
                    //url: 'page/confirm.php',
                    success: function(response) {
                        var valueToPass = 'I am order';
                        window.location.href = 'confirm.php?param=' + encodeURIComponent(valueToPass);
                    }
                });
            });
        });
    </script>
</body>

</html>