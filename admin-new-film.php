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
  <title>Limelight | Admin New Film</title>

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
          <a class="nav__button button--negative" href="logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
        </li>
      </ul>

    </div>
  </nav>





  <!-- Admin panel content
  ------------------------------------->
  <section class="admin-new-film">
    <div class="admin-new-film__container container">

      <h1 class="admin-new-film__heading">Add New Film</h1>


      <!-- PHP shows success confirmation when new film added -->
      <?php

      if ($_GET['success'] == 'success') {
        echo '<span class="admin-new-film__success">Film added successfully</span>';
      }

      ?>


      <!-- Film form -->
      <form class="admin-new-film__form form" action="new-film-request.php" method="POST" enctype="multipart/form-data">

        <!-- Title -->
        <label for="title" class="form__label">Title</label>
        <input name="title" id="title" type="text" class="form__text-input" maxlength="50" required>

        <!-- Age Rating -->
        <label for="age-rating" class="form__label">Age Rating</label>
        <input name="age-rating" id="age-rating" type="text" class="form__text-input" maxlength="3" required>

        <!-- Genre -->
        <label for="genre" class="form__label">Genre</label>
        <select name="genre" class="form__select" id="genre" >
          <option value="">Select genre</option>
          <option value="Action">Action</option>
          <option value="Adventure">Adventure</option>
          <option value="Comedy">Comedy</option>
          <option value="Horror">Horror</option>
          <option value="Romance">Romance</option>
          <option value="Sci-Fi">Sci-Fi</option>
          <option value="Fantasy">Fantasy</option>
          <option value="Musical">Musical</option>
          <option value="Drama">Drama</option>
          <option value="Family">Family</option>
        </select>

        <!-- Runtime -->
        <label for="runtime" class="form__label">Runtime (format: Xh XXm)</label>
        <input name="runtime" id="runtime" type="text" class="form__text-input" maxlength="8" required>

        <!-- Trailer -->
        <label for="trailer" class="form__label">Trailer URL</label>
        <input name="trailer" id="trailer" type="text" class="form__text-input" maxlength="500" required>

        <!-- Stock -->
        <label for="stock" class="form__label">Stock</label>
        <input name="stock" id="stock" type="text" class="form__text-input" maxlength="3" required>

        <!-- Summary -->
        <label for="summary" class="form__label">Summary (limit 500 characters)</label>
        <textarea name="summary" id="summary" cols="50" rows="5" class="form__text-area" maxlength="500" required></textarea>

        <!-- Film Poster -->
        <!-- File name can't include apostrophies as they mess with SQL -->
        <label for="image" class="form__label"><u>Upload Film Poster</u><br><br>(files should be in .jpg, .jpeg or .png format. File names should only include characters a-z, A-Z and 0-9.)</label>
        <br>
        <input name="image" id="image" type="file" class="form__file-upload-button" required>

        <!-- Submit / Reset -->
        <input name="submit" type="submit" value="Add Film" class="form__button button--primary button--large">
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