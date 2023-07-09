<?php
session_start();
session_destroy();
?>

<html>

<head>
    <title>Movie Shack</title>
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 2000); // Delay of 2 seconds (2000 milliseconds)
    </script>
</head>

<body>
    <h1>Logged out successfully</h1>
</body>

</html>