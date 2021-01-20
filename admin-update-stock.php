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
if (isset($_POST['update'])) {
  mysqli_query($connection, "UPDATE films SET stock ='$_POST[stock]' WHERE title ='$_POST[title]'");

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
  <title>Limelight | Admin Update Stock</title>

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
  <section class="admin-update-stock">
    <div class="admin-update-stock__container container">

      <h1 class="admin-update-stock__heading">Update Stock</h1>



      <!-- Search bar component -->
      <form class="admin-update-stock__search-bar search-bar" action="admin-update-stock.php" method="POST">
        
        <label for="searchbox" hidden>Search for a film</label>
        <input type="text" name="searchTerm" class="search-bar__input" id="searchbox" placeholder="Search film title ...">

        <!-- Search button -->
        <button type="submit" name="search" class="search-bar__button button--positive"><span class="fas fa-search"></i> Search</button>

      </form>


      <p class="admin-update-stock__instruction">Run an empty search to refresh the user list.</p>


      <!-- Success confirmation - shown when user details changed -->
      <?php

      if ($_GET['success'] == 'success') {
        echo '<span class="admin-update-stock__success">Changes successful</span>';
      }

      ?>



      <!-- Film stock table (data table component) -->
      <div class="admin-update-stock__data-table data-table">

        <!-- Table headings -->
        <form class="data-table__form">
          <label for="title" hidden>title</label>
          <input type="text" id="title" class="data-table__heading" value="Title" readonly>

          <label for="stock" hidden>stock</label>
          <input type="text" id="stock" class="data-table__heading" value="Stock" readonly>

          <input type="submit" class="data-table__button--hidden button--primary" value="Update">
        </form>
        <hr>


        <!-- Table content - PHP creates separate form for each film, taking info from DB -->
        <?php

        // If search term exists, show requested content only
        if ($searchTerm != '') {
          $query = mysqli_query($connection, "SELECT * FROM films WHERE title LIKE '%$searchTerm%' ORDER BY title");
        }
        // Else if search term isn't set, show all content from DB
        else {
          $query = mysqli_query($connection, "SELECT * FROM films ORDER BY title");
        }

        while ($row = mysqli_fetch_array($query)) {
          extract($row);
          echo "<form class='data-table__form' action='admin-update-stock.php' method='POST'>";

          echo "<label for='$title' hidden>title</label>";
          echo "<input name='title' type='text' id='$title' class='data-table__input left-align' value='$title' readonly>";

          echo "<label for='$title$stock' hidden>stock</label>";
          echo "<input name='stock' type='text' id='$title$stock' class='data-table__input' value='$stock'>";

          echo "<input name='update' type='submit' class='data-table__button button--primary' value='Update'>";
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
          <a class="footer__social--icon" href="#" target="_blank"><span class="fab fa-facebook-f"></i></a>
          <a class="footer__social--icon" href="#" target="_blank"><span class="fab fa-youtube"></i></a>
          <a class="footer__social--icon" href="#" target="_blank"><span class="fab fa-twitter"></i></a>
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