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
  header("Location: " . $_SESSION['redirect'] . "?section=register&error=usernameError");
}


// Check password matches confirmPassword - if it doesn't, return to register form with password error in URL
elseif ($_SESSION['password'] != $_SESSION['confirm-password']) {
  header("Location: " . $_SESSION['redirect'] . "?section=register&error=passwordError");
}


// If above checks ok, insert data into DB
mysqli_query($connection, "INSERT INTO users (username, password, date_of_birth, email, admin) VALUES ('$_SESSION[username]', '$_SESSION[password]', '$_SESSION[dob]', '$_SESSION[email]', '$_GET[admin]')");


// Set user age (only if user is not admin - ensures admin user's age doesn't get reset)
if ($_SESSION['admin'] != 'admin') {
  list($year, $month, $day) = explode('-', $_SESSION['dob']);
    
  $timeOfBirth = mktime(0, 0, 0, $month, $day, $year);

  $_SESSION['userAge'] = floor((time() - $timeOfBirth) / 31556926);
}


// Set reg-success variable to true - used to provide success alert following successful login - see bottom of index.php
// Not applicable to admins adding new user
if ($_SESSION['admin'] != 'admin') {
  $_SESSION['registrationSuccess'] = true;
  header("Location: login-request.php");
}
else {
  header("Location: " . $_SESSION['redirect'] . "?success=success");
}

?>