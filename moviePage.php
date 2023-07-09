<?php
// Check PHP error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check session
session_start();

// Include favorite
include  __DIR__ . "/backend/favorite.php";
?>


<?php

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

?>

<!DOCTYPE html>
<html>

<head>
    <title>Movie Shack</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <div class="center">
        <h1 class="center Large">Movie Shack</h1>
        <p class="controls">
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
            Welcome <?php echo $loggedInUserID; ?>
            <a href="./index.php?username=" . urlencode($username)">Home</a>
            <a href="./profile.php?id=<?php echo $loggedInUserID; ?>">My Account</a>
            <a href="logout.php">Logout</a>
        </div>
    <?php
            } else {
    ?>
        <div style="text-align: right;">
            <a href="./index.php">Home</a>
            <a href="./createaccount.php">Create Account</a>
            <a href="./login.php">Login</a>
        </div>


    <?php
            }

    ?>
    </p>


    <div>

        <form action="search.php" method="GET" style="text-align: right;">
            <input type="text" name="query" placeholder="Search" style="padding: 5px;">
            <input type="submit" value="Go" style="padding: 5px;">
        </form>

    </div>
    <br><br>
    <div style="background: #2F4C83; color: white; height: 100%;  padding: 20px;">

        <?php

        $username = $_GET['username'] ?? $_SESSION['username'] ?? null;
        $movieId = $_GET['movie_id'];

        if ($username) {
            // Display Favorite or Add Faavorite
            $username = $_GET['username'] ?? $_SESSION['username'];

            // Check if movie added to Favorite
            $isFav = isAddToFavorite($username, $movieId);

            // If movie added to fav, show delete
            if ($isFav === TRUE) {
                echo "<form action='backend/favorite.php' method='post'>";
                echo "<input type='text' id='username' name='username' value='$username' hidden>";
                echo "<input type='text' id='movieid' name='movieid' value='$movieId' hidden>";
                echo "<input type='submit' name='DeleteFavorite' class='button' value='- Favorite' style='background-color: black; color: red; font-size: 100%;' />";
                echo '</form>';
            } else {
                echo "<form action='backend/favorite.php' method='post'>";
                echo "<input type='text' id='username' name='username' value='$username' hidden>";
                echo "<input type='text' id='movieid' name='movieid' value='$movieId' hidden>";
                echo "<input type='submit' name='AddFavorite' class='button' value='+ Favorite' style='background-color: black; color: green; font-size: 100%;' />";
                echo '</form>';
            }
        } else {
            echo "<form action='backend/favorite.php' method='post'>";
            echo "<input type='text' id='movieid' name='movieid' value='$movieId' hidden>";
            echo "<input type='submit' name='AddFavoriteNotLoggedinUser' class='button' value='+ Favorite' style='background-color: black; color: green; font-size: 100%;' />";
            echo '</form>';
        }

        ?>

        <button style="background-color: black; color: green; font-size: 100%;">Rate Movie</button>
        <?php
        $movieId = $_GET['movie_id'];
        $host = 'localhost';
        $user = 'root';
        $password = "";
        $db_name = 'id21003775_movies';
        $con = mysqli_connect($host, $user, $password, $db_name);

        $movieData = "SELECT * FROM MOVIE WHERE MOVIE.Movie_Id='" . $movieId . "';";
        $movieInfo = $con->query($movieData);
        $movie1 = $movieInfo->fetch_assoc();

        $actor_query_string = "SELECT * FROM MOVIE M, CASTMEMBERS C, WorksOn W WHERE M.Movie_Id=W.Movie_Id AND W.Cast_Id=C.Cast_Id AND M.Movie_Id ='" . $movieId . "';";
        $actors = $con->query($actor_query_string);

        $comments_query_string = "SELECT * FROM COMMENTS WHERE Movie_Id='" . $movieId . "';";
        $comments = $con->query($comments_query_string);


        //Added here
        //$querydiscussion = "SELECT Discussion_Title FROM Discussion WHERE MOVIE.Movie_id='".$movieId."';";
        $querydiscussion = "SELECT * FROM Discussion JOIN MOVIE ON Discussion.Movie_id = MOVIE.Movie_id WHERE MOVIE.Movie_id = '" . $movieId . "';";
        $resultdiscussion = mysqli_query($con, $querydiscussion);







        //Code to display movies
        echo "<h1 class='center'>" . $movie1['Title'] . "</h1><br>";
        echo '<iframe width="100%" height="500" src="' . $movie1['link'] . '"  frameborder="10" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';

        echo '<p style="color: lightblue;">4.3 stars out of 300 reviews </p>';




        $CastMembers = "<p><b class='Large'>Cast Members: </b>";


        $actors = $con->query($actor_query_string);

        if ($actors) {
            $CastMembers = "<p><b class='Large'>Cast Members: </b>";

            while ($actor = $actors->fetch_assoc()) {
                $CastMembers = $CastMembers . $actor['FName'] . $actor['LName'] . ", ";
            }
        } else {
            // Handle the query error
            echo "Error executing actors query: " . mysqli_error($con);
        }


        $CastMembers = $CastMembers . "</p>";
        echo $CastMembers;


        echo "<p><b class='Large'>Release Date: </b>" . $movie1['ReleaseDate'] . "</p>";
        echo "<p><b class='Large'>Description: </b>" . $movie1['Description'] . "</p>";
        //End of movie display code



        // Added here discussion BEGINS HERE
        // Output each row as a column with Post_Title above Post_Body
        echo "<p><b class='Large'>Discussion</b></p>";
        while ($row = mysqli_fetch_assoc($resultdiscussion)) {
            $discussionId = $row["Discussion_ID"]; // Get the discussion ID for the current row
            echo "<div><a href='view_discussion.php?discussion_id=" . $discussionId . "' style='font-size: 30px; font-weight: bold;'>" . $row["Discussion_Title"] . "</a> <span style='font-size: 18px;'> &nbsp;&nbsp;Posted by: <a href='profile.php?uid=" . $row["username"] . "'>" . $row["username"] . "</a></span></div>";
        }

        // End of discussion post; this displays all discussion titles related to that movie




        //This is the start discussion button, this will open a new page to start a new discussion
        echo "<ul>";
        while ($resultdiscussion = $resultdiscussion->fetch_assoc()) {
            echo "<li><p>" . $resultdiscussion['Disucssion_Body'] . "</p></li>";
        }
        echo "</ul>";
        echo '<button class="button1"><a href="./discussion.php?movie_id=' . $movie1['Movie_Id'] . '">Start a New Discussion</a></button>';
        //end of start new discussion
        ?>

    </div>
    </div>
</body>

</html>