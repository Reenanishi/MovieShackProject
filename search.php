<?php
// Check PHP error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check session
session_start();

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
  <title>The Movie Shack</title>
  <link rel="stylesheet" href="./css/styles.css">


  <div class="center">
    <h1 class="center Large">The Movie Shack</h1>
    <p class="controls"><?php
                        $loggedInUserID = $_GET['username'] ?? null;
                        if (!$loggedInUserID) {
                          $loggedInUserID = $_SESSION['username'] ?? null;
                        }

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
  <br></p>






  <style>
    #container {
      display: flex;
    }

    #form {
      flex: 1;
      margin-right: 20px;
    }

    #previews {
      flex: 1;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table td {
      padding: 5px;
    }

    .preview {
      margin-bottom: 20px;
    }

    .preview img {
      max-width: 200px;
    }

    .preview-title {
      font-weight: bold;
    }

    .preview-rating {
      margin-top: 5px;
      font-style: italic;
    }

    .preview-description {
      margin-top: 5px;
    }

    .preview-release-date {
      margin-top: 5px;
    }

    #submit-button {
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div id="container">
    <div id="form">
      <p>Do a new movie search here:</p>
      <table>
        <tr>
          <td>Movie Title:</td>
          <td><input type="text" id="movie-title" required></td>
        </tr>
        <tr>
          <td>Release Date:</td>
          <td><input type="date" id="release-date" required></td>
        </tr>
        <tr>
          <td>Genre:</td>
          <td><input type="text" id="genre"></td>
        </tr>
        <tr>
          <td>MPAA Rating:</td>
          <td><input type="text" id="mpaa-rating" required></td>
        </tr>
        <tr>
          <td>Duration:</td>
          <td><input type="text" id="duration"></td>
        </tr>
        <tr>
          <td>Description:</td>
          <td><input type="text" id="description" required></td>
        </tr>
        <tr>
          <td>Video Link:</td>
          <td><input type="text" id="video-link"></td>
        </tr>
        <tr>
          <td>Image Link:</td>
          <td><input type="text" id="image-link"></td>
        </tr>
        <tr>
          <td>Director:</td>
          <td><input type="text" id="director"></td>
        </tr>
        <tr>
          <td>Actors:</td>
          <td><input type="text" id="actors"></td>
        </tr>
        <tr>
          <td>Writers:</td>
          <td><input type="text" id="writers"></td>
        </tr>
      </table>
      <button id="submit-button">Submit</button>
      <p id="required-fields"><em>* Required fields</em></p>
    </div>
    <div id="previews">
      <p> Search Results:</p>
      <div class="preview">
        <img src="image.png" alt="Movie Poster">
        <div class="preview-title">Movie Title 1</div>
        <div class="preview-rating">MPAA Rating: PG-13</div>
        <div class="preview-description">This movie is about a villian and a hero.</div>
        <div class="preview-release-date">Release Date: January 1, 2023</div>
      </div>
      <div class="preview">
        <img src="image.png" alt="Movie Poster">
        <div class="preview-title">Movie Title 2</div>
        <div class="preview-rating">MPAA Rating: R</div>
        <div class="preview-description">This movie is about a villian and a hero.</div>
        <div class="preview-release-date">Release Date: February 15, 2023</div>
      </div>
      <div class="preview">
        <img src="image.png" alt="Movie Poster">
        <div class="preview-title">Movie Title 3</div>
        <div class="preview-rating">MPAA Rating: PG</div>
        <div class="preview-description">This movie is about a villian and a hero.</div>
        <div class="preview-release-date">Release Date: March 30, 2023</div>
      </div>
    </div>
  </div>

  <script>
    // code for handling the form submission goes here
  </script>
</body>

</html>