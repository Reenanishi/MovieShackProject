<!DOCTYPE html>
<html>

<head>
	<title>The Movie Shack</title>
	<link rel="stylesheet" href="./css/styles.css">

</head>

<body>

	<div class="center">

		<h1 class="center">Add Cast Member</h1>
		<div class="form" style="background: #2F4C83; ">


			<form method="POST">
				First Name: <input class="form" name="fName"></input><br>
				Last Name: <input class="form" name="lName"></input><br>
				Biography: <textarea class="form" rows="6" id="bio" name="bio" cols="50" ;></textarea><br>
				<input style="width: 100%; font-size: 20px;" type="submit" name="submit" value="Submit"></input>
			</form>


			<button style="width: 100%; padding: 10px; font-size: 20px;"><a href="./index.php">Cancel</a></button>



			<?php
			function addCastMember()
			{
				echo "Add cast member";


				$firstName = $_POST['fName'];
				$lastName = $_POST['lName'];
				$bio = $_POST['bio'];

				$host = 'localhost';
				$user = 'root';
				$password = "";
				$db_name = 'id21003775_movies';
				$mysqli = new mysqli($host, $user, $password, $db_name);


				$actorQuery = "INSERT INTO CASTMEMBERS( `FName`, `LName`, `Bio`) VALUES ('" . $firstName . "','" . $lastName . "','" . $bio . "')";

				$mysqli->query($actorQuery);
				header("Location: index.php");
			}

			if (isset($_POST['submit'])) {

				addCastMember();
			}

			?>



			<div>
			</div>

</body>

</html>