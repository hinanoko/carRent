<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Confirm Order</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: hsl(158, 71%, 28%);
            color: #fff;
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

        .store-name {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .store-name h1 {
            font-family: 'Righteous', cursive;
            font-size: 36px;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="header-container">
        <div class="header-left">
            <img src="../pictures/logo.png" alt="Logo" class="header-icon">
            <div class="store-name">
                <h1>Motor Rent Confirm</h1>
            </div>
        </div>
    </div>

    <div>
        <p>this is the confirm page</p>
        <img src="../pictures/confirm.jpg" alt="Confirmation Image">
        <?php
        // 接收传递的参数
        if (isset($_GET['param'])) {
            $paramValue = $_GET['param'];
            // 处理接收到的参数值
            echo '接收到的参数值：' . htmlspecialchars($paramValue);
        } else {
            echo '未接收到参数值';
            $paramValue = null;
        }
        ?>
        <br>
        <!-- 确认订单的链接 -->
        <a href="#" id="confirmOrderLink" onclick="confirmOrder('<?php echo htmlspecialchars($paramValue); ?>')">Click here to confirm your order</a>
    </div>

    <script>
        function confirmOrder(orderId) {
            if (!orderId) {
                console.error('Order ID is missing.');
                return;
            }

            console.log(orderId)

            // 发送 AJAX 请求
            $.ajax({
                url: '../controller/update_status.php', // PHP 文件的 URL
                type: 'POST',
                data: {
                    order_id: orderId
                },
                success: function(response) {
                    console.log(response)
                    console.log('Order status updated successfully!');
                    // 可选: 执行其他操作,如更新 UI 等
                },
                error: function(xhr, status, error) {
                    console.error('Error updating order status:', error);
                    // 可选: 处理错误情况
                }
            });
        }
    </script>
</body>

</html>