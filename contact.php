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
  <title>Limelight | Contact Us</title>

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
        <li class="nav__item"><a href="#" class="nav__link active">Contact</a></li>
        

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





  <!-- Contact Form
  ------------------------------------->

  <section class="contact">
    <div class="contact__container container">

      <!-- Heading -->
      <h1 class="contact__heading">Contact Us</h1>

      <!-- Sub-Heading -->
      <p class="contact__subheading">If you would like to get in touch, please fill in the form below and we will get back to you as soon as we can.</p>


      <form class="contact__form form" action="#" method="POST">

        <label for="name" class="form__label">Name</label>
        <input name="name" type="text" class="form__text-input" required>

        <label for="email" class="form__label">Email</label>
        <input name="email" type="text" class="form__text-input" required>

        <label for="message" class="form__label">Message</label>
        <textarea name="message" cols="50" rows="5" class="form__text-area" placeholder="Type your message here ..." required></textarea>

        <input name="submit" type="submit" value="Submit" class="form__button button--primary button--large">
        <input name="reset" type="reset" value="Reset" class="form__button button--negative button--large">
        
      </form>

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
        <a href="#top" class="footer__link">Contact</a>
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