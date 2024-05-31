<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Confirm Order</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* 整体样式 */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
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

        /* 主体内容样式 */
        .content-container {
            padding: 20px;
            text-align: center;
        }

        .content-container img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .content-container p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* 确认订单链接样式 */
        #confirmOrderLink {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        #confirmOrderLink:hover {
            background-color: #555;
        }

        #confirmOrderLink i {
            margin-right: 5px;
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

    <div class="content-container">
        <p>This is the confirmation page.</p>
        <img src="../pictures/confirm.jpg" alt="Confirmation Image">
        <?php
        // 接收传递的参数
        if (isset($_GET['param'])) {
            $paramValue = $_GET['param'];
            // 处理接收到的参数值
            //echo 'Get the value：' . htmlspecialchars($paramValue);
        } else {
            //echo 'didn't get the value';
            $paramValue = null;
        }
        ?>
        <br>
        <!-- 确认订单的链接 -->
        <a href="#" id="confirmOrderLink" onclick="confirmOrder('<?php echo htmlspecialchars($paramValue); ?>')"><i class="fas fa-check-circle"></i>Click here to confirm your order</a>
    </div>

    <script>
        function confirmOrder(orderId) {
            if (!orderId) {
                console.error('Order ID is missing.');
                return;
            }

            console.log(orderId);

            // 发送 AJAX 请求
            $.ajax({
                url: '../controller/update_status.php', // PHP 文件的 URL
                type: 'POST',
                data: {
                    order_id: orderId
                },
                success: function(response) {
                    console.log(response);
                    console.log('Order status updated successfully!');
                    // 5秒后自动跳转到主页面
                    setTimeout(function() {
                        parent.parent.document.getElementById("indexPanel").src = "../main.html"
                    }, 5000);
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