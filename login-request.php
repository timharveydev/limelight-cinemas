<?php

session_start();

// Connection
include 'connection.php';


// Automatically login if $_SESSION['username'] is already set - e.g. if the user has just completed the registration form
if (isset($_SESSION['username'])) {
  header("Location: index.html?login=success");
}


// If $_SESSION['username'] not already set, standard log in process below:
else {
  
  // User input variables
  $_SESSION['username'] = $_POST['username'];
  $_SESSION['password'] = $_POST['password'];



  // Check username and password exist in DB
  $query = mysqli_query($connection, "SELECT * FROM users WHERE username='$_SESSION[username]' AND password='$_SESSION[password]'");

  // If details not found, return to login form with error
  if (!mysqli_num_rows($query) == 1) {
    header("Location: login-register.php?section=login&error=user_details_not_found");
  }

  // If details found ...
  else {

    // Get info from 'users' table and store 'date_of_birth' and 'email' values in session variables
    $query = mysqli_query($connection, "SELECT * FROM users WHERE username='$_SESSION[username]'");

    while ($row = mysqli_fetch_array($query)) {
      extract($row);
      
      $_SESSION['dob'] = $date_of_birth;
      $_SESSION['email'] = $email;
    }

    // Redirect to index page
    header("Location: index.html?login=success");
  }

}

?>