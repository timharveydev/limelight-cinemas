<?php

// Connection
include 'connection.php';


// User input variables
$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];
$dob = $_POST['date-of-birth'];
$email = $_POST['email'];


// Check username is not already taken
$query = mysqli_query($connection, "SELECT * FROM users WHERE username='$username'");

if (mysqli_num_rows($query) > 0) {
  header("Location: login-register.php?section=register&error=usernameError");
}

// Check password matches confirmPassword
elseif ($password !== $confirmPassword) {
  header("Location: login-register.php?section=register&error=passwordError");
}

// If above checks ok, insert data into DB
else {


  // Include email, if provided
  if ($email != '') {
    mysqli_query($connection, "INSERT INTO users (username, password, date_of_birth, email) VALUES ('$username', '$password', '$dob', '$email')");
  }

  // Exclude email, if not provided
  else {
    mysqli_query($connection, "INSERT INTO users (username, password, date_of_birth) VALUES ('$username', '$password', '$dob')");
  }


  // THIS NEEDS TO BE IMPROVED - USE SESSIONS INSTEAD OF GET
  header("Location: login-request.php?username=$username&password=$password");
}

?>