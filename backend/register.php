<?php
/*
Account register management Class

This class povides centalize access of create account
*/

// Error rreporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session Start
session_start();

// Include files
include_once  __DIR__ . "./../database/dbconnection.php";

$connection = getDbConnecion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $biography = $_POST['biography'];

    $name = mysqli_real_escape_string($connection, $name);
    $lastname = mysqli_real_escape_string($connection, $lastname);
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $biography = mysqli_real_escape_string($connection, $biography);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Upload the image
    $image = $_FILES['image']['tmp_name'];
    $imageData = addslashes(file_get_contents($image));

    // Insert the user into the database
    $sql = "INSERT INTO users (username, password, name, lastname, email, biography, image) 
            VALUES ('$username', '$hashedPassword', '$name', '$lastname', '$email', '$biography', '$imageData')";

    if ($connection->query($sql) === TRUE) {
        echo "<script>window.location.href = '../index.php';</script>";
    } else {
        header("Location: ../createaccount.php?error=Registration failed.");
    }
}

$connection->close();
