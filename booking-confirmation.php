<?php

session_start();


// If user not logged in or under 18 or if previous URL not booking.php,  send alert and redirect to index.php
if (!isset($_SESSION['username']) || $_SESSION['userAge'] < 18 || $_SESSION['redirect'] != '/~HNCWEBMR4/limelight-cinemas/booking.php') {
  echo '<script type="text/javascript">'; 
  echo 'alert("You do not have permission to view this page");';
  echo 'window.location.href = "index.php";';
  echo '</script>';
}


// Connection
include 'connection.php';


// Stores current URL minus arguments
$_SESSION['redirect'] = strtok($_SERVER['REQUEST_URI'], '?');


// Set variables to be used in the Booking Confirmation Section
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


// Set booking reference code (age rating + first letter of each word of the film title + quantity)
$words = explode(" ", "$title");
$acronym = "";

foreach ($words as $w) {
  $acronym .= $w[0];
}

$referenceCode = $age_rating . $acronym . $_POST['quantity'];


// Update film stock in DB
$updatedStock = $stock - $_POST['quantity'];
mysqli_query($connection, "UPDATE films SET stock='$updatedStock' WHERE ID='$_GET[filmID]'");

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
  <title>Limelight | Booking Confirmation</title>

  <!-- CSS
  --------------------------------------------------------->
  <link rel="stylesheet" href="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/css/main.css">

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

      <div class="nav__burger" onclick="toggleMenu()"><i class="fas fa-bars"></i></div>

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
            echo '<a class="nav__button button--negative" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>';
          }
          
          else {
            echo '<a class="nav__button button--positive" href="login-register.php?section=login"><i class="fas fa-sign-in-alt"></i> Login</a>';
          }
          
          ?>
        </li>
      </ul>


      <!-- Login/logout button - for small devices -->
      <!-- PHP code changes nav button type and content depending on whether a user is logged in or not -->
      <?php

      if (isset($_SESSION['username'])) {
        echo '<a class="nav__button button--negative mobile-only" href="logout.php"><i class="fas fa-sign-out-alt"></i></a>';
      }
      
      else {
        echo '<a class="nav__button button--primary mobile-only" href="login-register.php?section=login"><i class="fas fa-sign-in-alt"></i></a>';
      }
      
      ?>

    </div>
  </nav>





  <!-- Booking Confirmation Section
  ------------------------------------->

  <section class="confirmation">
    <div class="confirmation__container container">

      <!-- Confirmation box -->
      <div class="confirmation-box">

        <!-- Heading -->
        <h2 class="confirmation-box__heading">Booking Success!</h2>

        <!-- Subheading -->
        <h3 class="confirmation-box__subheading"><?php echo "You have booked $_POST[quantity] tickets to see $title." ?></h3>

        <!-- Details -->
        <p class="confirmation-box__details">Your booking reference code:</p>
        <p class="confirmation-box__details--large"><?php echo $referenceCode ?></p>
        <br><br>
        <p class="confirmation-box__details">Please make a note of your booking reference code as you will be required to show it on arrival at the cinema. If you provided an email address during registration, a confirmation email will be sent to you.</p>
        <br><br>
        <p class="confirmation-box__details">Thank you, we hope you enjoy the film!</p>
        <br><br>

        <!-- Return to homepage -->
        <a class="confirmation-box__return" href="index.php">Return to homepage</a>
        
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


  <!-- JAVASCRIPT
  --------------------------------------------------------->
  <script type='text/javascript' src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/js/toggleMenu.js"></script>


  <!-- END DOCUMENT
  --------------------------------------------------------->
  
</body>
</html>