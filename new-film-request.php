<?php

session_start();


// If previous URL not login-register.php, send alert and redirect to index.php
if ($_SESSION['redirect'] != '/~HNCWEBMR4/limelight-cinemas/admin-new-film.php') {
  header("Location: index.php");
  exit();
}


// Connection
include 'connection.php';


// Form input variables
// Replace apostrophes in strings to avoid SQL errors
$title = str_replace("'", "&#39;", $_POST['title']);
$age_rating = $_POST['age-rating'];
$genre = $_POST['genre'];
$runtime = str_replace("'", "&#39;", $_POST['runtime']);
$trailer = str_replace("'", "&#39;", $_POST['trailer']);
$stock = $_POST['stock'];
$summary = str_replace("'", "&#39;", $_POST['summary']);
$image = $_FILES['image']['name'];


// Move uploaded image file to 'img/user_uploads' directory
move_uploaded_file($_FILES['image']['tmp_name'], "img/user_uploads/$image");


// Insert data into DB
mysqli_query($connection, "INSERT INTO films (title, age_rating, genre, runtime, summary, image, trailer, stock) VALUES ('$title', '$age_rating', '$genre', '$runtime', '$summary', '$image', '$trailer', '$stock')");


// Redirect with success alert
header("Location: " . $_SESSION['redirect'] . "?success=success");

?>