<?php
// Check PHP error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check session
session_start();

// Include favorite
include_once  __DIR__ . "/backend/favorite.php";
include_once  __DIR__ . "/backend/recommendation.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="./css/styles.css">
    <style>
        .profile-section {
            display: flex;
        }

        .profile-photo {
            flex: 1;
        }

        .profile-info {
            flex: 1;
            padding-left: 20px;
        }

        .lists-section {
            display: flex;
            justify-content: space-between;
        }

        .lists-section>div {
            flex: 1;
            padding-right: 20px;
        }
    </style>
</head>

<body>

    <?php
    $host = 'localhost';
    $user = 'root';
    $password = "";
    $db_name = 'id21003775_movies';
    $connection = new mysqli($host, $user, $password, $db_name);

    if ($connection->connect_error) {
        die('Could not connect: ' . $connection->connect_error);
    }

    $loggedInUserID = $_SESSION['username'] ?? null;
    $uid = $_GET['uid'] ?? null;



    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['follow'])) {

        $loggedInUserID = $_SESSION['username'] ?? null;
        $uid = $_GET['uid'] ?? null;



        // Check if already following
        $checkQuery = "SELECT * FROM Followers WHERE username = '$loggedInUserID' AND following = '$uid'";
        $checkResult = $connection->query($checkQuery);

        if ($checkResult && $checkResult->num_rows > 0) {
            echo "You are already following this user.";
        } else {
            // Insert new follower
            $insertQuery = "INSERT INTO Followers (username, following) VALUES ('$loggedInUserID', '$uid')";
            if ($connection->query($insertQuery) === TRUE) {
                echo "You are now following this user.";
            } else {
                echo "Error: " . $insertQuery . "<br>" . $connection->error;
            }
        }
    }

    $query = "SELECT username, biography, image FROM users WHERE username = '$uid'";
    $result = $connection->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // $loggedInUserID = $row['username'];
        $biography = $row['biography'];
        $imageData = $row['image'];
    }

    $connection->close();
    ?>

    <div style="text-align: right;">
        <a href="index.php?uid=<?php echo $loggedInUserID; ?>">Home</a>
        <a href="./logout.php?uid=<?php echo $loggedInUserID; ?>">Logout</a>
    </div>

    <div class="profile-section">
        <div class="profile-info">
            <h2><?php echo $uid; ?></h2>

            <div class="profile-photo">
                <?php if ($imageData) : ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($imageData); ?>" alt="Profile Photo" width="200" height="200">
                <?php else : ?>
                    <img src="images/profile/image.png" alt="Default Profile Photo" width="200" height="200">
                <?php endif; ?>
            </div>
            <form method="POST">
                <input type="hidden" name="loggedInUserID" value="<?php echo $uid; ?>">
                <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                <button name="follow" style="background-color: black; color: green; font-size: 100%;">+ Follow</button>
            </form>

            <div class="lists-section">
                <div class="followed-users">
                    <h3>Followed Users</h3>
                    <table>
                        <?php
                        $host = 'localhost';
                        $user = 'root';
                        $password = "";
                        $db_name = 'id21003775_movies';
                        $connection = new mysqli($host, $user, $password, $db_name);

                        $followedQuery = "SELECT following FROM Followers WHERE username = '$uid'";
                        $followedResult = $connection->query($followedQuery);

                        if ($followedResult && $followedResult->num_rows > 0) {
                            for ($i = 1; $followedRow = $followedResult->fetch_assoc(); $i++) {
                                $following = $followedRow['following'];
                                echo "<tr><td><a href='profile.php?uid=$following'>$following</a></td></tr>";

                                if ($i === 10 && $followedResult->num_rows > 10) {
                                    echo "<tr><td><a href='following.php'>Click here for more</a></td></tr>";
                                    break;
                                }
                            }
                        } else {
                            echo "<tr><td>No followed users.</td></tr>";
                        }

                        $followedResult->free();
                        ?>
                    </table>
                </div>


                <div class="favorite-movies">
                    <h3>Favorite Movies</h3>
                    <?php
                    // Display Favorite or Add Faavorite
                    $username = $_GET['username'] ?? $_SESSION['username'];

                    // Check if movie added to Favorite
                    $result = getFavorites($username);

                    echo "<table>";
                    // If movie added to fav, show delete
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $movieid = $row["movieid"];
                            $movieTitle = $row["Title"];
                            echo "<tr>";
                            echo "<td>";
                            echo "<a href='moviePage.php?movie_id=$movieid'>$movieTitle</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo "<td>";
                        echo "No fav found";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    ?>
                </div>

                <div class="recommended-movies">
                    <h3>Recommended Movies</h3>
                    <?php

                    $username = $_GET['username'] ?? $_SESSION['username'];

                    // Display getRecommendation
                    $result = getRecommendation($username);

                    echo "<table>";
                    // If recommendation exists
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $movieid = $row["Movie_Id"];
                            $movieTitle = $row["Title"];
                            echo "<tr>";
                            echo "<td>";
                            echo "<a href='moviePage.php?movie_id=$movieid'>$movieTitle</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo "<td>";
                        echo "No fav found";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    ?>
                </div>
            </div>
        </div>
    </div>

    <p>About me:<br><?php echo $biography; ?></p>
</body>

</html>