<?php
// Check PHP error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Alert error
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo '<script type="text/javascript">';
    echo " alert('ERROR :' + '$error')";
    echo '</script>';
}

// Alert success
if (isset($_GET['success'])) {
    $success = $_GET['success'];
    echo '<script type="text/javascript">';
    echo " alert('SUCCESS :' + '$success')";
    echo '</script>';
}

// Include register
include  __DIR__ . "/backend/register.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>The Movie Shack</title>
    <link rel="stylesheet" href="./css/styles.css">
    <style>
        .size {
            columns: 200;
            font-size: 30px;
            width: 200px;
        }
    </style>
</head>

<body>
    <h2>Create an Account</h2>
    <form method="POST" action="backend/register.php" enctype="multipart/form-data">
        <label for="name">First Name:</label>
        <input type="text" name="name" id="name" class="size" required><br><br>

        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" id="lastname" class="size" required><br><br>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" class="size" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="size" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" class="size" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Please enter a password with at least 8 characters, one capital letter, one number, and one symbol." required>
        <br><br>Please enter a password with at least 8 characters, one capital letter, one number, and one symbol.<br><br>

        <label for="biography">Biography:</label>
        <textarea name="biography" id="biography" class="size" rows="4" cols="50" required></textarea><br><br>

        <label for="image">Profile Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>

</html>