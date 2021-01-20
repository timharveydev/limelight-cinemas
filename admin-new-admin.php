<?php

session_start();


// If user not admin send alert and redirect to index.php
if ($_SESSION['admin'] != 'admin') {
  echo '<script type="text/javascript">'; 
  echo 'alert("You do not have permission to view this page");';
  echo 'window.location.href = "index.php";';
  echo '</script>';
}


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
  <title>Limelight | Admin New Admin</title>

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
  <section class="admin-new-admin">
    <div class="admin-new-admin__container container">

      <h1 class="admin-new-admin__heading">Add New Admin User</h1>


      <!-- PHP shows success confirmation when new user added -->
      <?php

      if ($_GET['success'] == 'success') {
        echo '<span class="admin-new-admin__success">Admin user added successfully</span>';
      }

      ?>


      <!-- Register form (this is the same form that appears on the register/login page) -->
      <!-- PHP code between label and input produces error spans -> error type is sent via URL from register-request.php -->
      <!-- PHP within input value parameters populates form fields with previous user input when returning from register-request.php with errors (excludes password for security) -->
      <form class="admin-new-admin__form form" action="register-request.php?admin=admin" method="POST">

        <label for="username" class="form__label">Username <span class="required">*</span></label>
        <?php if($_GET['error'] == 'usernameError') {echo '<span class="form__error">Sorry, this username already exists</span>';} ?>
        <input name="username" id="username" type="text" class="form__text-input" maxlength="40" required>

        <label for="password" class="form__label">Password (8-12 characters) <span class="required">*</span></label>
        <input name="password" id="password" type="password" class="form__text-input" minlength="8" maxlength="12" required>

        <label for="confirm-password" class="form__label">Confirm Password <span class="required">*</span></label>
        <?php if($_GET['error'] == 'passwordError') {echo '<span class="form__error">Password does not match</span>';} ?>
        <input name="confirm-password" id="confirm-password" type="password" class="form__text-input" minlength="8" maxlength="12" required>

        <label for="date-of-birth" class="form__label">Date of Birth <span class="required">*</span></label>
        <input name="date-of-birth" id="date-of-birth" type="date" class="form__text-input datepicker" min="1900-01-01" required> <!-- See setDateInputMax.min.js -->

        <label for="email" class="form__label">Email (optional)</label>
        <input name="email" id="email" type="text" class="form__text-input" maxlength="40">

        <!-- Allows register-request.php to set $_SESSION['admin'] = 'admin' -->
        <input type="hidden" name="admin" value="admin">

        <input name="submit" type="submit" value="Add Admin User" class="form__button button--primary button--large">
        <input name="reset" type="reset" value="Reset" id="reset" class="form__button button--negative button--large">
        <label for="reset" hidden>Reset</label>
        
      </form>

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