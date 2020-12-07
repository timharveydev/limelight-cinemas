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
  <title>Limelight | Register & Login</title>

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

<!-- PHP passes 'arg' from URL into toggleSection() function to determine which content is displayed in the 'Login & Registration Screen Content' section below -->
<body id="top" onload="toggleSection('<?php echo $_GET[section]; ?>')">

  <!-- MAIN CONTENT
  --------------------------------------------------------->

  <!-- Navigation
  ------------------------------------->
  <nav class="nav">
    <div class="nav__container container">

      <div class="nav__logo">
        <a href="index.html"><img src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/img/logo.svg" alt="Limelight Cinemas Logo"></a>
      </div>

      <ul class="nav__list">
        <li class="nav__item"><a href="#" class="nav__link">What's On?</a></li>
        <li class="nav__item"><a href="#" class="nav__link">About</a></li>
        <li class="nav__item"><a href="contact.php" class="nav__link">Contact</a></li>
        <li class="nav__item"><a href="login-register.php?section=login" class="nav__button button--positive"><i class="fas fa-sign-in-alt"></i> Login</a></li>
      </ul>

    </div>
  </nav>


  


  <!-- Login & Registration Screen Content
  ------------------------------------->

  <!-- Content displayed is determined by the toggleSection() function - see body element above "MAIN CONTENT" heading -->
  <section class="login-register">
    <div class="login-register__container container">

      <!-- Section toggler component - .active class toggled by JS toggleSection() function -->
      <div class="section-toggler">
        <a class="section-toggler__toggle-button" id="register-button" onclick="toggleSection('register')">Register</a>
        <a class="section-toggler__toggle-button" id="login-button" onclick="toggleSection('login')">Login</a>
      </div>


      <!-- Heading - text content is added by JS toggleSection() function depending on the section chosen on the toggler component above -->
      <h1 class="login-register__heading"></h1>


      <!-- Registration form - display:none is toggled by the JS toggleSection() function -->
      <!-- PHP code between label and input produces error spans -> error type is sent via URL from register-request.php or login-request.php -->
      <!-- PHP within input value parameters populates form fields with previous user input when returning from register-request.php with errors (excludes password for security) -->
      <form class="register__form form" action="register-request.php" method="POST">

        <label for="username" class="form__label">Username <span class="required">*</span></label>
        <?php if($_GET['error'] == 'usernameError') {echo '<span class="form__error">Sorry, this username already exists</span>';} ?>
        <input name="username" type="text" class="form__text-input" maxlength="40" required value="<?php echo $_SESSION['username']; ?>">

        <label for="password" class="form__label">Password (8-12 characters) <span class="required">*</span></label>
        <input name="password" type="password" class="form__text-input" maxlength="12" required>

        <label for="confirm-password" class="form__label">Confirm Password <span class="required">*</span></label>
        <?php if($_GET['error'] == 'passwordError') {echo '<span class="form__error">Password does not match</span>';} ?>
        <input name="confirm-password" type="password" class="form__text-input" max-length="12" required>

        <label for="date-of-birth" class="form__label">Date of Birth <span class="required">*</span></label>
        <input name="date-of-birth" type="date" class="form__text-input datepicker" min="1900-01-01" required value="<?php echo $_SESSION['dob']; ?>"> <!-- See setDateInputMax.js -->

        <label for="email" class="form__label">Email (optional)</label>
        <input name="email" type="text" class="form__text-input" maxlength="40" value="<?php echo $_SESSION['email']; ?>">

        <input name="submit" type="submit" value="Submit" class="form__button button--primary button--large">
        <input name="reset" type="reset" value="Reset" class="form__button button--negative button--large">
        
      </form>


      <!-- Login form - display:none is toggled by the JS toggleSection function -->
      <form class="login__form form" action="login-request.php" method="POST">
        <label for="username" class="form__label">Username</label>
        <?php if($_GET['error'] == 'user_details_not_found') {echo '<span class="form__error">Details not found - you need to register before you can login</span>';} ?>
        <input name="username" type="text" class="form__text-input" required>

        <label for="password" class="form__label">Password</label>
        <input name="password" type="password" class="form__text-input" required>

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
        <a href="#" class="footer__link">What's On?</a>
        <a href="#" class="footer__link">About</a>
        <a href="#" class="footer__link">Contact</a>
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


  <!-- JAVASCRIPT
  --------------------------------------------------------->
  <script type='text/javascript' src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/js/toggleSection.js"></script>
  <script type='text/javascript' src="http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/js/setDateInputMax.js"></script>


  <!-- END DOCUMENT
  --------------------------------------------------------->
  
</body>
</html>