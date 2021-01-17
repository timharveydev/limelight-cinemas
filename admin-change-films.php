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
  $title = str_replace("'", "&#39;", $_POST['title']);
  $summary = str_replace("'", "&#39;", $_POST['summary']);
  $trailer = str_replace("'", "&#39;", $_POST['trailer']);

  mysqli_query($connection, "UPDATE films SET title='$title', summary='$summary', trailer='$trailer' WHERE ID='$_POST[id]'");

  // Reload page with success alert
  header("Location: " . $_SESSION['redirect'] . "?success=success");
}


// Delete from database when Delete button is pressed
if (isset($_POST['delete'])) {
  mysqli_query($connection, "DELETE FROM films WHERE ID='$_POST[id]'");

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
  <title>Limelight | Admin Change Films</title>

  <!-- CSS
  --------------------------------------------------------->
  <link rel="stylesheet" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/css/main.css">
  <!-- PHP includes css styles specific to junior & unregistered users -->
  <?php
    if (!isset($_SESSION['username']) || $_SESSION['userAge'] < 18) {
      echo '<link rel="stylesheet" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/css/junior-unregistered.css">';
    }
    if (isset($_SESSION['username']) && $_SESSION['userAge'] < 18) {
      echo '<link rel="stylesheet" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/css/junior-only.css">';
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
          <a class="nav__button button--negative" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>

    </div>
  </nav>





  <!-- Admin panel content
  ------------------------------------->
  <section class="admin-change-films">
    <div class="admin-change-films__container container">

      <h1 class="admin-change-films__heading">Change / Remove Films</h1>



      <!-- Search bar component -->
      <form class="admin-change-films__search-bar search-bar" action="admin-change-films.php" method="POST">
        
        <input type="text" name="searchTerm" class="search-bar__input" placeholder="Search film title ...">

        <!-- Search button -->
        <button type="submit" name="search" class="search-bar__button button--positive"><i class="fas fa-search"></i> Search</button>

      </form>


      <p class="admin-change-films__instruction">Run an empty search to refresh the film list.</p>


      <!-- Success confirmation - shown when user details changed -->
      <?php

      if ($_GET['success'] == 'success') {
        echo '<span class="admin-change-films__success">Changes successful</span>';
      }

      ?>



      <!-- Films table (data table component) -->
      <div class="admin-change-films__data-table data-table">

        <!-- Table headings -->
        <form class="data-table__form">
          <input type="text" class="data-table__heading" value="Title" readonly>
          <input type="text" class="data-table__heading" value="Summary" readonly>
          <input type="text" class="data-table__heading" value="Trailer" readonly>
          <input type="submit" class="data-table__button--hidden button--primary" value="Update">
          <input type="submit" class="data-table__button--hidden button--negative" value="Delete">
        </form>
        <hr>


        <!-- Table content - PHP creates separate form for each user, taking info from DB -->
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
          echo "<form class='data-table__form' action='admin-change-films.php' method='POST'>";
          echo "<input name='title' type='text' class='data-table__input left-align' value='$title' maxlength='50' required>";
          echo "<textarea name='summary' class='data-table__textarea' maxlength='500' required>$summary</textarea>";
          echo "<textarea name='trailer' class='data-table__textarea' maxlength='500' required>$trailer</textarea>";
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
          <a class="footer__social--icon" href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
          <a class="footer__social--icon" href="#" target="_blank"><i class="fab fa-youtube"></i></a>
          <a class="footer__social--icon" href="#" target="_blank"><i class="fab fa-twitter"></i></a>
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