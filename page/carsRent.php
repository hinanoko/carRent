<!DOCTYPE html>
<html>

<head></head>

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
    ?>
    <!-- 在页面中显示$info -->
    <div>
        <?php
        // 检查session中是否有$info，并显示到页面上
        if (isset($_SESSION['info'])) {
            echo "Info from session: " . $_SESSION['info'];
        }
        ?>
    </div>
</body>

</html>