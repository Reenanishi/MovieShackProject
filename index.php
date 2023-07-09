<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$loggedInUsername = '';
if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
} /*else {

    header("Location: login.php");
    exit();
}*/
?>

<!DOCTYPE html>
<html>

<head>
    <title>The Movie Shack</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body style="background-image: url('images/index/filmbackground.png');">
    <div class="center" style="background-color: black; width: 900px;">
        <h1 class="center">The Movie Shack</h1>
        <div>
            <?php

            $host = 'localhost';
            $user = 'root';
            $password = "";
            $db_name = 'id21003775_movies';
            $con = mysqli_connect($host, $user, $password, $db_name);
            if (mysqli_connect_errno()) {
                die("Failed to connect with MySQL: " . mysqli_connect_error());
            }

            $loggedInUserID = $_GET['username'] ?? null;
            if (!$loggedInUserID) {
                $loggedInUserID = $_SESSION['username'] ?? null;
            }

            if ($loggedInUserID) {
            ?>

                <div style="text-align: right;">
                    <a href="./index.php">Home</a>
                    <a href="./profile.php?uid=<?php echo $loggedInUserID; ?>"><?php echo $loggedInUserID; ?> </a>

                    <a href="./AddMovie.php">Suggest A Movie</a>
                    <a href="logout.php">Logout</a>
                </div>
            <?php
            } else {
            ?>
                <div style="text-align: right;">
                    <a href="./index.php">Home</a>
                    <a href="./createaccount.php">Create Account</a>
                    <a href="./login.php">Login</a>
                    <a href="./AddMovie.php">Suggest A Movie</a>
                </div>
            <?php
            }
            ?>
            <div>
                <br><br>
                <form action="search.php" method="GET" style="text-align: right;">
                    <input type="text" name="query" placeholder="Search" style="padding: 5px;">
                    <input type="submit" value="Go" style="padding: 5px;">
                </form>
            </div>
            <?php

            $host = 'localhost';
            $user = 'root';
            $password = "";
            $db_name = 'id21003775_movies';
            $con = new mysqli($host, $user, $password, $db_name);

            $movieQuery = "SELECT * FROM MOVIE ORDER BY Rand();";
            $movieInfo = $con->query($movieQuery);

            echo "<h1>Top Rated</h1>";
            echo "<div class='carousel'>";
            for ($x = 0; $x < 6; $x++) {
                $currentMovie = mysqli_fetch_array($movieInfo);
                echo "<div class='carousel__item'><a href='./moviePage.php?movie_id=" . $currentMovie['Movie_Id'] . "'>" . $currentMovie['Title'] . "</a></div>";
            }
            echo "</div>";

            echo "<h1>MOVIE SHELF</h1>";
            echo "<table>";
            foreach ($movieInfo as $movie) {
                echo "<tr>";
                echo "<td><a href='./moviePage.php?movie_id=" . $movie['Movie_Id'] . "'><img src='./images/moviePosters/" . $movie['imgLocation'] . "'></a></td>";
                echo "<td>";
                echo $movie['Title'] . "<br><br>Released: " . $movie['ReleaseDate'] . "<br><br>" . $movie['Description'];
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
    <script src="main.js"></script>
</body>

</html>