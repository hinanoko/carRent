<!DOCTYPE html>
<html>

<head>
    <title>Clear Order Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div>
        <p>xiaoxiaoying</p>
        <button id="clearOrderTableBtn">Clear Order Table</button>
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