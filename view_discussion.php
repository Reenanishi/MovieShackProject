<?php
session_start();
?>
<DOCTYPE html>
	<html>

	<head>
		<title>View Conversation</title>
		<link rel="stylesheet" href="./css/styles.css">
	</head>

	<body>
		<center>
			<div class="background" style="background-color: darkgrey; position:center; width: 1000px;">
				<div class="center" style="background-color: lightgrey; position:center;width: 900px;">
					<h1 class="center">Movie Shack</h1>
					<div>
						<?php
						$host = 'localhost';
						$user = 'root';
						$password = "";
						$db_name = 'id21003775_movies';
						$connection = new mysqli($host, $user, $password, $db_name);
						$loggedInUserID = $_SESSION['username'] ?? $_GET['username'] ?? null;



						if ($loggedInUserID) {
						?>
							<div style="text-align: right;">
								<a href="./index.php">Home</a>
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
						<div id="body">
							<?php
							// Connect to the database
							$host = 'localhost';
							$user = 'root';
							$password = "";
							$db_name = 'id21003775_movies';
							$connection = new mysqli($host, $user, $password, $db_name);

							if ($connection->connect_error) {
								die('Could not connect: ' . $connection->connect_error);
							}




							// Retrieve the discussion_ID from the query string
							$discussion_id = isset($_GET['discussion_id']) ? $_GET['discussion_id'] : null;
							$title = "";
							$body = "";

							if ($discussion_id) {
								$query5 = "SELECT Discussion_Title, Discussion_Body, Movie_ID, username FROM Discussion WHERE DISCUSSION_ID = '" . mysqli_real_escape_string($connection, $discussion_id) . "'";
								$query1 = "SELECT * FROM COMMENTS WHERE DISCUSSION_ID = '" . mysqli_real_escape_string($connection, $discussion_id) . "'";
								$result5 = mysqli_query($connection, $query5);
								$result2 = mysqli_query($connection, $query1);

								if ($result5) {
									if (mysqli_num_rows($result5) > 0) {
										$row = mysqli_fetch_assoc($result5);
										$title = $row['Discussion_Title'];
										$body = $row['Discussion_Body'];
										$movie_id = $row['Movie_ID']; // Update variable name to 'Movie_ID'
										$username = $row['username'];
									} else {
										echo "<p><center>No post found with Discussion_ID $discussion_id.</center></p>";
									}
								} else {
									// Handle the query execution error
									echo "<p><center>Error executing query: " . mysqli_error($connection) . "</center></p>";
								}
							} else {
								echo "<p><center>No Discussion_ID specified.</center></p>";
							}

							// Process the comment form submission
							if (isset($_POST['submit'])) {
								// Retrieve the form data
								$user_comment = $_POST['user_comment'];

								// Insert the comment into the Comments table
								$query = "INSERT INTO COMMENTS (UserComment, Discussion_ID, Movie_ID, username) VALUES ('" . mysqli_real_escape_string($connection, $user_comment) . "', " . mysqli_real_escape_string($connection, $discussion_id) . ", " . mysqli_real_escape_string($connection, $movie_id) . ", '" . mysqli_real_escape_string($connection, $loggedInUserID) . "')";

								$result = mysqli_query($connection, $query); // Execute the query

								if (!$result) {
									die('Error executing query: ' . mysqli_error($connection));
								}

								// Retrieve the newly inserted comment
								$comment_id = mysqli_insert_id($connection);
							}

							// Close the database connection
							mysqli_close($connection);
							?>

							<h2><?php echo $title; ?></h2>
							<p><?php echo $body; ?></p>
							<p>Posted by: <a href="profile.php?uid=<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a></p>


							<form method="POST" style="width: 900px; height: 200px;"><br>
								<textarea name="user_comment" rows="4" cols="50" placeholder="Add comment here"></textarea><br>
								<input type="hidden" name="discussion_id" value="<?php echo $discussion_id; ?>">
								<input type="submit" name="submit" value="Add Comment">
							</form>

							<h3>Comments:</h3>
							<?php
							// Output the comments
							if ($result2 && mysqli_num_rows($result2) > 0) {
								while ($row = mysqli_fetch_assoc($result2)) {

									echo '<p>' . $row['UserComment'] . ' - <a href="profile.php?uid=' . $row['username'] . '">' . $row['username'] . '</a></p>';
								}
							} else {
								echo '<p>No comments available.</p>';
							}
							?>
	</body>

	</html>