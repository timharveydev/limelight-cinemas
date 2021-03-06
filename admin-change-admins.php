<?php

session_start();


// If user not admin send alert and redirect to index.php
if ($_SESSION['admin'] != 'admin') {
  echo '<script type="text/javascript">'; 
  echo 'alert("You do not have permission to view this page");';
  echo 'window.location.href = "index.php";';
  echo '</script>';
}


// Connection
include 'connection.php';


// Stores current URL minus arguments
$_SESSION['redirect'] = strtok($_SERVER['REQUEST_URI'], '?');


// Store search term from search bar
// Replace apostrophe in string to avoid SQL errors
if (isset($_POST['search'])) {
  $searchTerm = str_replace("'", "&#39;", $_POST['searchTerm']);
}
else {
  $searchTerm = '';
}


// Update database when Update button is pressed
// Replace apostrophes in strings to avoid SQL errors
if (isset($_POST['update'])) {
  $username = str_replace("'", "&#39;", $_POST['username']);
  $password = str_replace("'", "&#39;", $_POST['password']);
  $dob = str_replace("'", "&#39;", $_POST['dob']);
  $email = str_replace("'", "&#39;", $_POST['email']);

  mysqli_query($connection, "UPDATE users SET username='$username', password='$password', date_of_birth='$dob', email='$email' WHERE ID='$_POST[id]'");

  // Reload page with success alert
  header("Location: " . $_SESSION['redirect'] . "?success=success");
}


// Delete from database when Delete button is pressed
if (isset($_POST['delete'])) {
  mysqli_query($connection, "DELETE FROM users WHERE ID='$_POST[id]'");

  // Reload page with success alert
  header("Location: " . $_SESSION['redirect'] . "?success=success");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>

  <!-- METAS & TITLE
  --------------------------------------------------------->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Tim Harvey">
  <meta name="description" content="A dynamic cinema website created for my HND Web Development course.">
  <title>Limelight | Admin Change Admins</title>

  <!-- CSS
  --------------------------------------------------------->
  <link rel="stylesheet" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/css/main.min.css">
  <!-- PHP includes css styles specific to junior & unregistered users -->
  <?php
    if (!isset($_SESSION['username']) || $_SESSION['userAge'] < 18) {
      echo '<link rel="stylesheet" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/css/junior-unregistered.min.css">';
    }
    if (isset($_SESSION['username']) && $_SESSION['userAge'] < 18) {
      echo '<link rel="stylesheet" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/css/junior-only.min.css">';
    }
  ?>

  <!-- FONTS
  --------------------------------------------------------->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

  <!-- FONT AWSOME
  --------------------------------------------------------->
  <script src="https://kit.fontawesome.com/6cc30ac4de.js" crossorigin="anonymous"></script>

  <!-- FAVICON
  --------------------------------------------------------->
  <link rel="icon" type="image/png" sizes="32x32" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/img/favicon/safari-pinned-tab.svg" color="#49b171">

</head>
<body id="top">

  <!-- MAIN CONTENT
  --------------------------------------------------------->

  <!-- Navigation (Mobile-specific stuff removed - admin section not used on mobile devices)
  ------------------------------------->
  <nav class="nav">
    <div class="nav__container container">

      <div class="nav__logo">
        <a href="index.php"><img src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/img/logo.svg" alt="Limelight Cinemas Logo"></a>
      </div>

      <ul class="nav__list">
        <li class="nav__item"><a href="index.php#films" class="nav__link">What's On?</a></li>
        <li class="nav__item"><a href="activities.php" class="nav__link">Activities</a></li>
        <li class="nav__item"><a href="about.php" class="nav__link">About</a></li>
        <li class="nav__item"><a href="contact.php" class="nav__link">Contact</a></li>

        <!-- Admin panel button - for large devices only -->
        <li class="nav__item mobile-hidden">
          <a class="nav__button button" href="admin-home.php">Admin Panel</a>
        </li>

        <!-- Logout button (login button not needed - admin pages not accessible unless logged in) -->
        <li class="nav__item mobile-hidden">
          <a class="nav__button button--negative" href="logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
        </li>
      </ul>

    </div>
  </nav>





  <!-- Admin panel content
  ------------------------------------->
  <section class="admin-change-admins">
    <div class="admin-change-admins__container container">

      <h1 class="admin-change-admins__heading">Change / Remove Admins</h1>



      <!-- Search bar component -->
      <form class="admin-change-admins__search-bar search-bar" action="admin-change-admins.php" method="POST">
        
        <label for="searchbox" hidden>Search for a film</label>
        <input type="text" name="searchTerm" class="search-bar__input" id="searchbox" placeholder="Search user details ...">

        <!-- Search button -->
        <button type="submit" name="search" class="search-bar__button button--positive"><span class="fas fa-search"></span> Search</button>

      </form>


      <p class="admin-change-admins__instruction">Run an empty search to refresh the user list.</p>


      <!-- Success confirmation - shown when user details changed -->
      <?php

      if ($_GET['success'] == 'success') {
        echo '<span class="admin-change-admins__success">Changes successful</span>';
      }

      ?>



      <!-- Admin users table (data table component) -->
      <div class="admin-change-admins__data-table data-table">

        <!-- Table headings -->
        <form class="data-table__form">
          <label for="username" hidden>username</label>
          <input type="text" id="username" class="data-table__heading" value="Username" readonly>

          <label for="password" hidden>password</label>
          <input type="text" id="password" class="data-table__heading" value="Password" readonly>

          <label for="date-of-birth" hidden>date of birth</label>
          <input type="text" id="date-of-birth" class="data-table__heading" value="Date of Birth" readonly>

          <label for="email" hidden>email</label>
          <input type="text" id="email" class="data-table__heading" value="Email" readonly>


          <input type="submit" class="data-table__button--hidden button--primary" value="Update">
          <input type="submit" class="data-table__button--hidden button--negative" value="Delete">
        </form>
        <hr>


        <!-- Table content - PHP creates separate form for each user, taking info from DB -->
        <?php

        // If search term exists, show requested content only
        if ($searchTerm != '') {
          $query = mysqli_query($connection, "SELECT * FROM users WHERE (admin = 'admin') AND (username LIKE '%$searchTerm%' OR password LIKE '%$searchTerm%' OR date_of_birth LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%') ORDER BY username");
        }
        // Else if search term isn't set, show all content from DB
        else {
          $query = mysqli_query($connection, "SELECT * FROM users WHERE admin = 'admin' ORDER BY username");
        }

        while ($row = mysqli_fetch_array($query)) {
          extract($row);
          echo "<form class='data-table__form' action='admin-change-admins.php' method='POST'>";

          echo "<label for='$username' hidden>username</label>";
          echo "<input name='username' type='text' id='$username' class='data-table__input' value='$username'>";

          echo "<label for='$ID$password' hidden>password</label>";
          echo "<input name='password' type='password' id='$ID$password' class='data-table__input' value='$password' minlength='8' maxlength='12'>";

          echo "<label for='$date_of_birth' hidden>date of birth</label>";
          echo "<input name='dob' type='text' id='$date_of_birth' class='data-table__input' value='$date_of_birth'>";

          echo "<label for='$email' hidden>email</label>";
          echo "<input name='email' type='text' id='$email' class='data-table__input' value='$email'>";
          
          echo "<input name='id' type='hidden' class='data-table__input' value='$ID'>";

          echo "<input name='update' type='submit' class='data-table__button button--primary' value='Update'>";
          echo "<input name='delete' type='submit' class='data-table__button button--negative' value='Delete'>";
          echo "</form>";
        }

        ?>


      </div>


    </div>
  </section>





  <!-- Footer
  ------------------------------------->
  <footer class="footer">
    <div class="footer__container container">

      <div class="footer__nav">
        <a href="index.php#films" class="footer__link">What's On?</a>
        <a href="activities.php" class="footer__link">Activities</a>
        <a href="about.php" class="footer__link">About</a>
        <a href="contact.php" class="footer__link">Contact</a>
      </div>


      <div class="footer__flex-wrapper">

        <div class="footer__social">
          <a class="footer__social--icon" href="#" target="_blank"><span class="fab fa-facebook-f"></span></a>
          <a class="footer__social--icon" href="#" target="_blank"><span class="fab fa-youtube"></span></a>
          <a class="footer__social--icon" href="#" target="_blank"><span class="fab fa-twitter"></span></a>
        </div>

        <div class="footer__copyright">
          &copy; 2020 Limelight Cinemas. All Rights Reserved.
        </div>

      </div>


      <div class="footer__link-to-top">
        <a href="#top" class="footer__link">Back to top</a>
      </div>

    </div>
  </footer>


  <!-- END DOCUMENT
  --------------------------------------------------------->
  
</body>
</html>