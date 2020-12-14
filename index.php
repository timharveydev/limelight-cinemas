<?php

session_start();

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
  <title>Limelight | Home</title>

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
<body id="top" class="fade-in" onload="document.querySelector('.fade-in').style.opacity='1'">

  <!-- MAIN CONTENT
  --------------------------------------------------------->

  <!-- Navigation
  ------------------------------------->
  <nav class="nav">
    <div class="nav__container container">

      <div class="nav__burger" onclick="toggleMenu()"><i class="fas fa-bars"></i></div>

      <div class="nav__logo">
        <a href="#"><img src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/img/logo.svg" alt="Limelight Cinemas Logo"></a>
      </div>

      <ul class="nav__list">
        <li class="nav__item"><a href="#" class="nav__link">What's On?</a></li>
        <!-- PHP adds activities link for junior users -->
        <?php
        if (isset($_SESSION['username']) && $_SESSION['userAge'] < 18) {
          echo '<li class="nav__item"><a href="#" class="nav__link">Activities</a></li>';
        }
        ?>
        <li class="nav__item"><a href="#" class="nav__link">About</a></li>
        <li class="nav__item"><a href="contact.php" class="nav__link">Contact</a></li>


        <!-- Nav button - for large devices -->
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


      <!-- Nav button - for small devices -->
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

  



  <!-- Full-Page Image Slider Component
  ------------------------------------->
  <div class="slider">
    <span class="slider__img">Image 1</span>
    <span class="slider__img">Image 2</span>
    <span class="slider__img">Image 3</span>
    <span class="slider__img">Image 4</span>
    <span class="slider__img">Image 5</span>
    <span class="slider__img">Image 6</span>
  </div>





  <!-- Hero Screen Content
  ------------------------------------->
  <section class="hero">
    <div class="hero__container container">

      <div class="hero__left-side">
        <h2 class="hero__pre-title">Welcome to</h2>
        <h1 class="hero__main-title"><span class="hero__main-title--primary-color">Lime</span>light</h1>
        <h3 class="hero__sub-title">Premier cinemas in Midlothian</h3>
      </div>

      <div class="hero__right-side">
        <!-- PHP determines which right-side hero content is displayed depending on if user is logged in and user age -->
        <?php
        // If no user logged in, display membership info 
        if (!isset($_SESSION['username'])) {
          echo '<h3 class="hero__sub-title">Become a member today ...</h3>';
          echo '<p class="hero__info">... to gain access to our full film database, book tickets and more!</p>';
          echo '<a href="login-register.php?section=register" class="hero__button button--primary button--large"><i class="fas fa-user-plus"></i> Register</a>';
        }
        // If user under 18, show activities info
        elseif ($_SESSION['userAge'] < 18) {
          echo '<h3 class="hero__sub-title">Visit our Activities page ...</h3>';
          echo '<p class="hero__info">... and put your knowledge to the test with some of our film trivia quizzes.</p>';
          echo '<a href="#" class="hero__button button--primary button--large"><i class="fas fa-trophy"></i> Activities</a>';
        }
        ?>
      </div>

      <a href="#" class="hero__button--absolute button--positive button--large">What's On? <i class="fas fa-arrow-down"></i></a>
      
    </div>
  </section>





  <!-- Footer
  ------------------------------------->
  <footer class="footer">
    <div class="footer__container container">

      <div class="footer__nav">
        <a href="#" class="footer__link">What's On?</a>
        <!-- PHP adds activities link for junior users -->
        <?php
        if (isset($_SESSION['username']) && $_SESSION['userAge'] < 18) {
          echo '<a href="#" class="footer__link">Activities</a>';
        }
        ?>
        <a href="#" class="footer__link">About</a>
        <a href="contact.php" class="footer__link">Contact</a>
      </div>


      <div class="footer__flex-wrapper">

        <div class="footer__social">
          <a class="footer__social--icon" href="#"><i class="fab fa-facebook-f"></i></a>
          <a class="footer__social--icon" href="#"><i class="fab fa-youtube"></i></a>
          <a class="footer__social--icon" href="#"><i class="fab fa-twitter"></i></a>
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





  <!-- Success alert - shown on successful registration -->
  <?php

  if ($_SESSION['registrationSuccess'] == true) {
    echo '<script>alert("Registration successful!\nYou are now logged in.");</script>';
    unset($_SESSION['registrationSuccess']);
  }

  ?>


  <!-- JAVASCRIPT
  --------------------------------------------------------->
  <script type='text/javascript' src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/js/toggleMenu.js"></script>


  <!-- END DOCUMENT
  --------------------------------------------------------->
  
</body>
</html>