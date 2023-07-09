<?php
/*
Favorite Management Class

This class povides centalize access of ADD, GET and DEL of Favorite categories
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once  __DIR__ . "./../database/dbconnection.php";

/*
Add Favorite
*/
function addFavorite($username, $movieid)
{
	$connection = getDbConnecion();
	$username = mysqli_real_escape_string($connection, $username);
	$movieid = mysqli_real_escape_string($connection, $movieid);

	$sql = "INSERT INTO MovieFav (username, movieid) VALUES ('$username', $movieid)";

	if ($connection->query($sql) === TRUE) {
		header("Location: ../moviePage.php?movie_id=$movieid&success=Favorite added successful");
	} else {
		header("Location: ../moviePage.php?movie_id=$movieid&error=Favorite added failed");
	}
}

/*
GET User favorites
*/
function isAddToFavorite($username, $movieid)
{
	$connection = getDbConnecion();
	$username = mysqli_real_escape_string($connection, $username);
	$movieid = mysqli_real_escape_string($connection, $movieid);

	$sql = "SELECT * FROM MovieFav WHERE username='$username' AND movieid=$movieid";
	$res = $connection->query($sql);
	if ($res->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}

/*
GET User favorites
*/
function getFavorites($username)
{
	$connection = getDbConnecion();
	$username = mysqli_real_escape_string($connection, $username);

	$sql = "SELECT * FROM MovieFav f INNER JOIN MOVIE m ON f.movieid = m.Movie_Id WHERE username='" . $username . "'";
	return $connection->query($sql);
}

/*
DELETE User favorite
*/
function deleteFavorite($username, $movieid)
{
	$connection = getDbConnecion();
	$username = $_POST['username'];
	$movieid = $_POST['movieid'];

	$username = mysqli_real_escape_string($connection, $username);
	$movieid = mysqli_real_escape_string($connection, $movieid);

	$sql = "DELETE FROM MovieFav WHERE username='" . $username . "' AND movieid='" . $movieid . "' ";

	if ($connection->query($sql) === TRUE) {
		header("Location: ../moviePage.php?movie_id=$movieid&success=Favorite deleted successful");
	} else {
		header("Location: ../moviePage.php?movie_id=$movieid&error=Favorite deleted failed");
	}
}

/*
Display error for not logged in user
*/
function addFavoriteNotLoggedinUser($movieid)
{
	header("Location: ../moviePage.php?movie_id=$movieid&error=User must be logged in to use favorite feature");
}

if (array_key_exists('AddFavorite', $_POST)) {
	addFavorite($_POST['username'], $_POST['movieid']);
} elseif (array_key_exists('DeleteFavorite', $_POST)) {
	deleteFavorite($_POST['username'], $_POST['movieid']);
} elseif (array_key_exists('AddFavoriteNotLoggedinUser', $_POST)) {
	addFavoriteNotLoggedinUser($_POST['movieid']);
}
