<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>The Movie Shack</title>
    <link rel="stylesheet" href="./CSS/styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .container {
            background-color: #228B22;
            padding: 20px;
            border-radius: 10px;
            width: 500px;
            text-align: center;
        }

        .container h1 {
            color: #ffffff;
            margin-bottom: 30px;
        }

        .container label {
            color: #ffffff;
        }

        .container input[type="text"],
        .container textarea {
            width: 100%;
            height: 30px;
            padding: 5px;
            margin-bottom: 10px;
        }

        .container textarea {
            height: 100px;
        }

        .container input[type="submit"] {
            width: auto;
            padding: 10px 20px;
            background-color: #ffffff;
            color: #2F4C83;
            border: none;
            cursor: pointer;
        }

        .container input[type="submit"]:hover {
            background-color: #dddddd;
        }

        .container a.button2 {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ffffff;
            color: #2F4C83;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .container a.button2:hover {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add a Comment</h1>

        <form method="POST">
            <label for="title">Post Title:</label><br>
            <input type="text" id="title" name="Discussion_Title" placeholder="Enter a topic title" required><br>
            <label for="content">Post Content:</label><br>
            <textarea id="content" name="Discussion_Body" placeholder="Start conversation here" required></textarea><br>
            <input type="submit" name="submit" value="Publish">
        </form>

        <?php
        $movieId = $_GET['movie_id'];
        echo "<a href='moviePage.php?movie_id=" . $movieId . "' class='button2'>Back</a>";

        function addDiscussion()
        {
            $discussiontitle = $_POST['Discussion_Title'];
            $discussionbody = $_POST['Discussion_Body'];
            $movieIdHolder = $_GET['movie_id'];
            $host = 'localhost';
            $user = 'root';
            $password = "";
            $db_name = 'id21003775_movies';
            $mysqli = new mysqli($host, $user, $password, $db_name);

            $loggedInUserID = $_SESSION['username'] ?? null;

            // Get the latest Discussion_ID from the Discussion table
            $getLastIdQuery = "SELECT MAX(Discussion_ID) AS LastDiscussionId FROM Discussion";
            $lastIdResult = $mysqli->query($getLastIdQuery);
            $row = $lastIdResult->fetch_assoc();
            $lastDiscussionId = $row['LastDiscussionId'];
            $newDiscussionId = $lastDiscussionId + 1;

            // Insert the new discussion into the Discussion table
            $discussionQuery = "INSERT INTO Discussion (`Discussion_ID`, `Discussion_Title`, `Discussion_Body`, `Movie_Id`, `username`) 
                            VALUES ('" . $newDiscussionId . "', '" . $discussiontitle . "', '" . $discussionbody . "', '" . $movieIdHolder . "', '" . $loggedInUserID . "');";
            $mysqli->query($discussionQuery);

            echo "<script>window.location.href = 'moviePage.php?movie_id=" . $movieIdHolder . "';</script>";
        }

        if (isset($_POST['submit'])) {
            addDiscussion();
        }
        ?>
    </div>
</body>

</html>