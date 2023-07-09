<!DOCTYPE html>
<html>

<head>
	<title>Movie Shack</title>
	<link rel="stylesheet" href="./CSS/styles.css">
	<style>
		.size {
			columns: 200;
			font-size: 30px;
			width: 200px;
		}
	</style>


</head>

<body>

	<div class="center">

		<h1 class="center">Suggest A Movie</h1>
		<div class="form" style="background: #2F4C83;">


			<form method="POST">
				Movie Title: <input class="size" name="title"></input><br>
				Release Date: <input class="size" name="release"></input><br>

				<?php
				echo "Genre: <select class='size' name='genre'>";
				$host = 'localhost';
				$user = 'root';
				$password = "";
				$db_name = 'id21003775_movies';
				$mysqli = new mysqli($server_name, $user_name, $password, $db_name);

				$genreQuery = "SELECT genre FROM `Genre`;";
				$genreData = $mysqli->query($genreQuery);

				$i = 1;
				foreach ($genreData as $key => $genre) {
					echo "<option value='" . $i . "'>" . $genre['genre'] . "</option>";
					$i++;
				}
				echo "</select><br>";
				?>
				Video Link: <input class="size" name="link"></input><br>
				Image Link: <input class="size" name="image"></input><br>
				Description: <textarea class="size" rows="10" cols="30" name="desc"></textarea><br>

				<input type="submit" name="submit" value="Submit"></input>
			</form>

			<?php
			function addMovie()
			{
				$title = str_replace('\'', '', $_POST['title']);
				$release = str_replace('\'', '', $_POST['release']);
				$genre = str_replace('\'', '', $_POST['genre']);
				$video = str_replace('\'', '', $_POST['link']);
				$image = str_replace('\'', '', $_POST['image']);
				$description = str_replace('\'', '', $_POST['desc']);

				$server_name = 'localhost';
				$user_name = 'root';
				$password = "";
				$db_name = 'MOVIES';
				$mysqli = new mysqli($server_name, $user_name, $password, $db_name);

				$movieQuery = "INSERT INTO `SuggestMovie`( `Title`, `ReleaseDate`, `Description`, `Genre_Id`, `link`, `imgLocation`) VALUES ('" . $title . "','" . $release . "','" . $description . "','" . $genre . "','" . $video . "','" . $image . "');";
				echo $movieQuery;
				$mysqli->query($movieQuery);

				header("Location: index.php");
			}

			if (isset($_POST['submit'])) {
				addMovie();
			}

			?>


			<div>
			</div>

</body>

</html>