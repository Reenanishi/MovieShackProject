<?php
/*
Recommendation Management Class

This class povides centalize access of GET user movie recommendation
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once  __DIR__ . "./../database/dbconnection.php";

/*
GET User recommendation
*/
function getRecommendation($username)
{
	$connection = getDbConnecion();
	$username = mysqli_real_escape_string($connection, $username);

	// Get random top 10 movies
	$sql = "SELECT * FROM MOVIE ORDER BY RAND() LIMIT 10;";
	return $connection->query($sql);
}
