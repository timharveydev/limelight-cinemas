<?php

session_start();

// Stores current URL minus arguments
$_SESSION['redirect'] = strtok($_SERVER['REQUEST_URI'], '?');

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
  <title>Limelight | About</title>

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
        <li class="nav__item"><a href="#" class="nav__link active">About</a></li>
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


        <!-- Login/logout button - for large devices -->
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





  <!-- About page content
  ------------------------------------->
  <section class="about">
    <div class="about__container container">

      <!-- Heading -->
      <h1 class="about__heading">About Us</h1>

      <!-- Cinema image -->
      <img class="about__image" src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/img/about.jpg" alt="Cinema screening room">


      <!-- Flex wrapper -->
      <div class="about__flex-wrapper">

        <div class="about__info">
          <!-- Who we are -->
          <h2 class="about__subheading">Who We Are</h2>
          <p class="about__text">Limelight Cinemas are an independant cinema group with venues situated throughout Midlothian. Our mission is to present the very best of what the film industry has to offer, whether it be brand new releases, time-proven classics or indie hits. We have seven separate screening rooms, which allows us to show seven films simultaneously at each showing time, Wed - Sun. Our film roster changes weekly so be sure to check back regularly to catch the latest and greatest, only at Limelight Cinemas.</p>

          <br>

          <!-- Ticket terms -->
          <h2 class="about__subheading">Ticket Terms & Conditions</h2>
          <p class="about__text">We operate an open ticket policy where tickets are valid for all showing times weekly. Simply turn up at your preffered showing time and present your ticket at the door. Tickets expire on Sundays after 8pm. Tickets are single use only. A maximum of four tickets can be reserved per person.</p>
        </div>


        <div class="about__showing-times" id="showing-times">
          <h2 class="about__subheading">Showing Times</h2>
          <table class="about__hours-table">
            <tr><th>Monday</th><td>Closed</td></tr>
            <tr><th>Tuesday</th><td>Closed</td></tr>
            <tr><th>Wed - Sun</th><td>11am</td></tr>
            <tr><th></th><td>2pm</td></tr>
            <tr><th></th><td>5pm</td></tr>
            <tr><th></th><td>8pm</td></tr>
          </table>
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
        <a href="#" class="footer__link">About</a>
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
  <script type='text/javascript' src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/js/toggleMenu.js"></script>


  <!-- END DOCUMENT
  --------------------------------------------------------->
  
</body>
</html>