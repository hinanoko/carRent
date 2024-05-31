<!DOCTYPE html>
<html>

<head>
    <script>
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
    </script>
</head>

<body>
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $info = $_POST['info'];
        echo "<div>Data is: " . $info . "</div>";
        // 将$info存储到session中
        $_SESSION['info'] = $info;
    } else {
        echo "Error: Invalid request method";
    }
    ?> < !--在页面中显示$info-->
        <div>
            <?php
            // 检查session中是否有$info，并显示到页面上
            if (isset($_SESSION['info'])) {
                echo "Info from session: " . $_SESSION['info'];
            }
            ?> </div>
</body>

</html>