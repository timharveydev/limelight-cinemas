<?php

session_start();

// Connection
include 'connection.php';


// User input variables
$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];
$_SESSION['confirm-password'] = $_POST['confirm-password'];
$_SESSION['dob'] = $_POST['date-of-birth'];
$_SESSION['email'] = $_POST['email'];


// Check username is not already taken - if it is, return to register form with username error in URL
$query = mysqli_query($connection, "SELECT * FROM users WHERE username='$_SESSION[username]'");

if (mysqli_num_rows($query) > 0) {
  header("Location: login-register.php?section=register&error=usernameError");
}


// Check password matches confirmPassword - if it doesn't, return to register form with password error in URL
elseif ($_SESSION['password'] != $_SESSION['confirm-password']) {
  header("Location: login-register.php?section=register&error=passwordError");
}


// If above checks ok, insert data into DB
else {

  // Include email, if provided
  if ($_SESSION['email'] != '') {
    mysqli_query($connection, "INSERT INTO users (username, password, date_of_birth, email) VALUES ('$_SESSION[username]', '$_SESSION[password]', '$_SESSION[dob]', '$_SESSION[email]')");
  }

  // Exclude email, if not provided
  else {
    mysqli_query($connection, "INSERT INTO users (username, password, date_of_birth) VALUES ('$_SESSION[username]', '$_SESSION[password]', '$_SESSION[dob]')");
  }


  
  // Set user age
  list($year, $month, $day) = explode('-', $_SESSION['dob']);
    
  $timeOfBirth = mktime(0, 0, 0, $month, $day, $year);

  $_SESSION['userAge'] = floor((time() - $timeOfBirth) / 31556926);


  // Set reg-success variable to true - used to provide success alert following successful login - see bottom of index.php
  // Head to login-request.php for automatic login
  $_SESSION['registrationSuccess'] = true;
  header("Location: login-request.php");
}

?>