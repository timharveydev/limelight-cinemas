<?php

session_start();


// If user not logged in or under 18 send alert and redirect to index.php
if (!isset($_SESSION['username']) || $_SESSION['userAge'] < 18) {
  echo '<script type="text/javascript">'; 
  echo 'alert("You do not have permission to view this page");';
  echo 'window.location.href = "index.php";';
  echo '</script>';
}


// Connection
include 'connection.php';


// Stores current URL minus arguments
$_SESSION['redirect'] = strtok($_SERVER['REQUEST_URI'], '?');


// Set variables to be used in the Booking Section
$query = mysqli_query($connection, "SELECT * FROM films WHERE ID=$_GET[filmID]");
while ($row = mysqli_fetch_array($query)) {
  extract($row);
  $ID;
  $title;
  $genre;
  $age_rating;
  $runtime;
  $stock;
  $image;
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
  <title>Limelight | Book Tickets</title>

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

  <!-- Navigation
  ------------------------------------->
  <nav class="nav">
    <div class="nav__container container">

      <div class="nav__burger" onclick="toggleMenu()"><span class="fas fa-bars"></span></div>

      <div class="nav__logo">
        <a href="index.php"><img src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/img/logo.svg" alt="Limelight Cinemas Logo"></a>
      </div>

      <ul class="nav__list">
        <li class="nav__item"><a href="index.php#films" class="nav__link">What's On?</a></li>
        <!-- PHP adds activities link for junior and admin users -->
        <?php

        if ((isset($_SESSION['username']) && $_SESSION['userAge'] < 18) || $_SESSION['admin'] == 'admin') {
          echo '<li class="nav__item"><a href="activities.php" class="nav__link">Activities</a></li>';
        }
        
        ?>
        <li class="nav__item"><a href="about.php" class="nav__link">About</a></li>
        <li class="nav__item"><a href="contact.php" class="nav__link">Contact</a></li>
        

        <!-- Admin panel button - for large devices only -->
        <!-- PHP code displays button only if admin user logged in -->
        <li class="nav__item mobile-hidden">
          <?php

          if ($_SESSION['admin'] == 'admin') {
            echo '<a class="nav__button button" href="admin-home.php">Admin Panel</a>';
          }
          
          ?>
        </li>


        <!-- Login/logout button -->
        <!-- PHP code changes nav button type and content depending on whether a user is logged in or not -->
        <li class="nav__item mobile-hidden">
          <?php

          if (isset($_SESSION['username'])) {
            echo '<a class="nav__button button--negative" href="logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>';
          }
          
          else {
            echo '<a class="nav__button button--positive" href="login-register.php?section=login"><span class="fas fa-sign-in-alt"></span> Login</a>';
          }
          
          ?>
        </li>
      </ul>


      <!-- Login/logout button - for small devices -->
      <!-- PHP code changes nav button type and content depending on whether a user is logged in or not -->
      <?php

      if (isset($_SESSION['username'])) {
        echo '<a class="nav__button button--negative mobile-only" href="logout.php"><span class="fas fa-sign-out-alt"></span></a>';
      }
      
      else {
        echo '<a class="nav__button button--primary mobile-only" href="login-register.php?section=login"><span class="fas fa-sign-in-alt"></span></a>';
      }
      
      ?>

    </div>
  </nav>





  <!-- Booking Section
  ------------------------------------->

  <section class="booking">
    <div class="booking__container container">

      <h1 class="booking__heading">Book Tickets</h1>


      <!-- Booking box -->
      <div class="booking-box">

        <!-- Film poster -->
        <div class="booking-box__img-div">
          <img src="img/user_uploads/<?php echo $image; ?>" alt="Film poster for <?php echo $title; ?>">
        </div>


        <!-- Film info & title -->
        <div class="booking-box__content-div">

          <div class="booking-box__flex-wrapper">
            <h2 class="booking-box__title"><?php echo $title; ?></h2>
            <hr class="booking-box__underline">
            <div class="booking-box__attributes">
              <p><?php echo $genre; ?> | Rating: <?php echo $age_rating; ?> | <span class="far fa-clock"></span> <?php echo $runtime; ?> | <a href="about.php#showing-times">Showing times</a></p>
            </div>
          </div>

          <!-- Disclaimer -->
          <p class="booking-box__disclaimer"><strong>Please note:</strong><br><br>There is a limit of 4 tickets per person.<br><br>Tickets are valid for the chosen film only and for any viewing time.<br><a href="about.php">Click here</a> for more information on viewing times and ticket terms & conditions.</p>


          <!-- Ticket selection -->
          <!-- PHP disables select & options depending on stock available in DB -->
          <form class="booking-box__form form" action="booking-confirmation.php?filmID=<?php echo $ID; ?>" method="POST">

            <label class="form__label" for="tickets"><strong>Quantity:</strong></label>

            <select name="quantity" class="form__select" id="tickets" <?php if ($stock < 1) { echo 'disabled'; } ?>>
              <option value="1" <?php if ($stock < 1) { echo 'disabled'; } ?>>1</option>
              <option value="2" <?php if ($stock < 2) { echo 'disabled'; } ?>>2</option>
              <option value="3" <?php if ($stock < 3) { echo 'disabled'; } ?>>3</option>
              <option value="4" <?php if ($stock < 4) { echo 'disabled'; } ?>>4</option>
            </select>

            <label class="form__label">(<?php echo $stock; ?> tickets remaining)</label>


            <!-- Submit button -->
            <?php

            // Active when stock > 0
            if ($stock > 0) {
              echo '<input class="form__button button--primary button--large" type="submit" name="submit" value="Book Now">';
            }
            // Disabled when stock <= 0
            else {
              echo '<input class="form__button button--disabled button--large" type="submit" name="submit" value="Book Now" disabled>';
            }

            ?>

          </form>

        </div>
      </div>

    </div>
  </section>





  <!-- Footer
  ------------------------------------->
  <footer class="footer">
    <div class="footer__container container">

      <div class="footer__nav">
        <a href="index.php#films" class="footer__link">What's On?</a>
        <!-- PHP adds activities link for junior and admin users -->
        <?php

        if ((isset($_SESSION['username']) && $_SESSION['userAge'] < 18) || $_SESSION['admin'] == 'admin') {
          echo '<a href="activities.php" class="footer__link">Activities</a>';
        }
        ?>
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


  <!-- JAVASCRIPT
  --------------------------------------------------------->
  <script type='text/javascript' src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/js/toggleMenu.min.js" defer></script>


  <!-- END DOCUMENT
  --------------------------------------------------------->
  
</body>
</html>