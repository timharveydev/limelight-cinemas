<?php

session_start();

// Connection
include 'connection.php';


// Form input variables
$title = $_POST['title'];
$age_rating = $_POST['age-rating'];
$genre = $_POST['genre'];
$runtime = $_POST['runtime'];
$trailer = $_POST['trailer'];
$stock = $_POST['stock'];
$summary = $_POST['summary'];
$image = $_FILES['image']['name'];


// Move uploaded image file to 'image_uploads' directory
move_uploaded_file($_FILES['image']['tmp_name'], "image_uploads/$image");


// Insert data into DB
mysqli_query($connection, "INSERT INTO films (title, age_rating, genre, runtime, summary, image, trailer, stock) VALUES ('$title', '$age_rating', '$genre', '$runtime', '$summary', '$image', '$trailer', '$stock')");


// Redirect with success alert
header("Location: " . $_SESSION['redirect'] . "?success=success");

?>