<?php
/*
Account authentcation management Class

This class povides feature to check authentcation
*/

// Error rreporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session Start
session_start();

// Include files
include_once  __DIR__ . "./../database/dbconnection.php";


/*
GET User recommendation
*/
function login($username, $password)
{

    $con = getDbConnecion();

    $username = stripcslashes($username);
    $username = mysqli_real_escape_string($con, $username);

    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Verify the entered password against the stored hash
        $hashedPassword = $row['password'];
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['username'] = $username;
            // Password is correct
            header("Location: ../index.php?username=" . urlencode($username));
            exit(); // exit after redirecting
        } else {
            // Password is incorrect
            header("Location: ../login.php?error=Login failed. Invalid username or password.");
        }
    } else {
        // No matching username found in the database
        header("Location: ../login.php?error=Login failed. Invalid username or password.");
    }
}

if (array_key_exists('Checklogin', $_POST)) {
    login($_POST['user'], $_POST['pass']);
}
