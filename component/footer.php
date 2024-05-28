<!DOCTYPE html>
<html>

<head>
    <title>Clear Order Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        p {
            color: #ffcc00;
            /* 修改这里的颜色 */
        }
    </style>
</head>

<body>
    <div>
        <p>Copyright © 2023-2024 All Rights Reserved, anything please contact kaedewang0726@gmail.com</p>
    </div>

    <script>
        $(document).ready(function() {
            $('#clearOrderTableBtn').click(function() {
                $.ajax({
                    url: '../controller/deleteAll.php',
                    type: 'GET',
                    success: function(response) {
                        alert(response);
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            });
        });
    </script>
</body>

</html>