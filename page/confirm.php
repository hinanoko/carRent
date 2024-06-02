<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Confirm Order</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../style/confirm.css">
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
        // Receive passed parameters
        if (isset($_GET['param'])) {
            $paramValue = $_GET['param'];
            // Process received parameter values
            //echo 'Get the value：' . htmlspecialchars($paramValue);
        } else {
            //echo 'didn't get the value';
            $paramValue = null;
        }
        ?>
        <br>
        <!-- Confirm order link -->
        <a href="#" id="confirmOrderLink" onclick="confirmOrder('<?php echo htmlspecialchars($paramValue); ?>')"><i class="fas fa-check-circle"></i>Click here to confirm your order</a>
    </div>

    <script>
        function confirmOrder(orderId) {
            if (!orderId) {
                console.error('Order ID is missing.');
                return;
            }

            console.log(orderId);

            // Send AJAX request
            $.ajax({
                url: '../controller/update_status.php', // The URL of a PHP file
                type: 'POST',
                data: {
                    order_id: orderId
                },
                success: function(response) {
                    console.log(response);
                    console.log('Order status updated successfully!');
                    alert("you have confirm the order successfully")
                    // Automatically jump to the main page in 5 seconds
                    setTimeout(function() {
                        parent.parent.document.getElementById("indexPanel").src = "../main.html"
                    }, 5000);
                },
                error: function(xhr, status, error) {
                    console.error('Error updating order status:', error);
                    //Optional: Handling error situations
                }
            });
        }
    </script>
</body>

</html>