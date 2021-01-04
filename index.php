<?php

session_start();

// Connection
include 'connection.php';


// Stores current URL minus arguments
$_SESSION['redirect'] = strtok($_SERVER['REQUEST_URI'], '?');


// Store search term from search bar, if set
$searchTerm = '';

if (isset($_POST['search'])) {
  // Replace apostrophe in string to avoid SQL errors
  $searchTerm = str_replace("'", "&#39;", $_POST['searchTerm']);
}


// Store selected genre, if set (will overwrite searchTerm above)
if (isset($_POST['action'])) {
  $searchTerm = 'action';
}
elseif (isset($_POST['adventure'])) {
  $searchTerm = 'adventure';
}
elseif (isset($_POST['comedy'])) {
  $searchTerm = 'comedy';
}
elseif (isset($_POST['horror'])) {
  $searchTerm = 'horror';
}
elseif (isset($_POST['romance'])) {
  $searchTerm = 'romance';
}
elseif (isset($_POST['sci-fi'])) {
  $searchTerm = 'sci-fi';
}
elseif (isset($_POST['fantasy'])) {
  $searchTerm = 'fantasy';
}
elseif (isset($_POST['musical'])) {
  $searchTerm = 'musical';
}
elseif (isset($_POST['drama'])) {
  $searchTerm = 'drama';
}
elseif (isset($_POST['family'])) {
  $searchTerm = 'family';
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
  <title>Limelight | Home</title>

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
        <li class="nav__item"><a href="#films" class="nav__link">What's On?</a></li>
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


        <!-- Login/logout button - for large devices -->
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

  



  <!-- HOMEPAGE
  ------------------------------------->

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
          echo '<a href="activities.php" class="hero__button button--primary button--large"><i class="fas fa-trophy"></i> Activities</a>';
        }
        ?>
      </div>


      <?php
        // If no user logged in, display membership info 
        if (isset($_SESSION['username']) && $_SESSION['userAge'] >= 18) {
          echo '<a href="#films" class="hero__button--absolute-primary button--primary button--large">What\'s On? <i class="fas fa-arrow-down"></i></a>';
        }
        else {
          echo '<a href="#films" class="hero__button--absolute-positive button--positive button--large">What\'s On? <i class="fas fa-arrow-down"></i></a>';
        }
      ?>
      
    </div>
  </section>





  <!-- FILMS SECTION
  ------------------------------------->

  <section class="films" id="films">
    <div class="films__container container">

      <!-- Heading -->
      <h1 class="films__heading">Films</h1>



      <!-- Alert/notification -->
      <!-- PHP displays registration/booking notice to unregistered/underage users -->
      <?php
        if (!isset($_SESSION['username'])) {
          echo '<p class="films__notice"><strong>Please note</strong> - only registered members can book tickets. <a href="login-register.php?section=register">Click here</a> to register today and gain access to our extended film database.</p>';
        }
        elseif ($_SESSION['userAge'] < 18) {
          echo '<p class="films__notice"><strong>Please note</strong> - you must be over 18 to book tickets.</p>';
        }
      ?>



      <!-- Search bar component -->
      <form class="films__search-bar search-bar" action="index.php#films" method="POST">
        
        <input type="text" name="searchTerm" class="search-bar__input" placeholder="Enter film title ...">

        <!-- Search button for most devices -->
        <button type="submit" name="search" class="search-bar__button button--positive"><i class="fas fa-search"></i> Search</button>

        <!-- Search button for phones -->
        <button type="submit" name="search" class="search-bar__button--mobile button--primary"><i class="fas fa-search"></i></button>

      </form>


      <p class="__instruction">Run an empty search to refresh the film list.</p>



      <!-- Genre criteria selectors component -->
      <!-- PHP sets active class and disables active buttons -->
      <form class="films__criteria-selectors criteria-selectors" action="index.php#films" method="POST">

        <button type="submit" class="criteria-selectors__selector <?php if (isset($_POST['action'])) {echo 'active';} ?>" name="action" <?php if (isset($_POST['action'])) {echo 'disabled';} ?>>Action</button>

        <button type="submit" class="criteria-selectors__selector <?php if (isset($_POST['adventure'])) {echo 'active';} ?>" name="adventure" <?php if (isset($_POST['adventure'])) {echo 'disabled';} ?>>Adventure</button>

        <button type="submit" class="criteria-selectors__selector <?php if (isset($_POST['comedy'])) {echo 'active';} ?>" name="comedy" <?php if (isset($_POST['comedy'])) {echo 'disabled';} ?>>Comedy</button>

        <button type="submit" class="criteria-selectors__selector <?php if (isset($_POST['horror'])) {echo 'active';} ?>" name="horror" <?php if (isset($_POST['horror'])) {echo 'disabled';} ?>>Horror</button>

        <button type="submit" class="criteria-selectors__selector <?php if (isset($_POST['romance'])) {echo 'active';} ?>" name="romance" <?php if (isset($_POST['romance'])) {echo 'disabled';} ?>>Romance</button>

        <button type="submit" class="criteria-selectors__selector <?php if (isset($_POST['sci-fi'])) {echo 'active';} ?>" name="sci-fi" <?php if (isset($_POST['sci-fi'])) {echo 'disabled';} ?>>Sci-Fi</button>

        <button type="submit" class="criteria-selectors__selector <?php if (isset($_POST['fantasy'])) {echo 'active';} ?>" name="fantasy" <?php if (isset($_POST['fantasy'])) {echo 'disabled';} ?>>Fantasy</button>

        <button type="submit" class="criteria-selectors__selector <?php if (isset($_POST['musical'])) {echo 'active';} ?>" name="musical" <?php if (isset($_POST['musical'])) {echo 'disabled';} ?>>Musical</button>

        <button type="submit" class="criteria-selectors__selector <?php if (isset($_POST['drama'])) {echo 'active';} ?>" name="drama" <?php if (isset($_POST['drama'])) {echo 'disabled';} ?>>Drama</button>

        <button type="submit" class="criteria-selectors__selector <?php if (isset($_POST['family'])) {echo 'active';} ?>" name="family" <?php if (isset($_POST['family'])) {echo 'disabled';} ?>>Family</button>

      </form>



      <!-- Film info box component -->
      <!-- Dynamically generated by PHP -->
      <?php

      // If search term exists and userAge over 18 ...
      if ($searchTerm != '' && $_SESSION['userAge'] >= 18) {
        $query = mysqli_query($connection, "SELECT * FROM films WHERE title LIKE '%$searchTerm%' OR genre='$searchTerm' ORDER BY title");
      }
      // If search term exists and userAge under 18 ...
      elseif ($searchTerm != '' && $_SESSION['userAge'] < 18) {
        $query = mysqli_query($connection, "SELECT * FROM films WHERE (title LIKE '%$searchTerm%' OR genre='$searchTerm') AND NOT age_rating=18 ORDER BY title");
      }
      // If search term isn't set and userAge over 18 ...
      elseif ($searchTerm == '' && $_SESSION['userAge'] >= 18) {
        $query = mysqli_query($connection, "SELECT * FROM films ORDER BY title");
      }
      // If search term exists and userAge over 18 ...
      elseif ($searchTerm == '' && $_SESSION['userAge'] < 18) {
        $query = mysqli_query($connection, "SELECT * FROM films WHERE NOT age_rating=18 ORDER BY title");
      }


      // Echo appology if no films found
      if (mysqli_num_rows($query) == 0) {
        echo 'No films found - please check back again soon.';
      }

      // Create film info box component for each film found
      while ($row = mysqli_fetch_array($query)) {
        extract($row);

        echo "<div class='film-info-box'>";

        echo "  <!-- Film poster -->";
        echo "  <div class='film-info-box__img-div'>";
        echo "    <img src='http://webdev.edinburghcollege.ac.uk/~HNCWEBMR4/limelight-cinemas/image_uploads/$image' alt='Film poster for $title'>";
        echo "  </div>";

        echo "  <!-- Film info & content -->";
        echo "  <div class='film-info-box__content-div'>";
        echo "    <div class='film-info-box__flex-wrapper'>";
        echo "      <h2 class='film-info-box__title'>$title</h2>";
        echo "      <hr class='film-info-box__underline'>";
        echo "      <div class='film-info-box__attributes'>";
        echo "        <p>$genre | Rating: $age_rating | <i class='far fa-clock'></i> $runtime | <a href='about.php#showing-times'>Showing times</a></p>";
        echo "      </div>";
        echo "    </div>";

        echo "    <p class='film-info-box__summary'><strong>Summary:</strong><br><br>$summary</p>";

        echo "    <div class='film-info-box__buttons'>";
        if (isset($_SESSION['username']) && $_SESSION['userAge'] >= 18) {
          echo "     <a href='$trailer' class='button' target='_blank'>View Trailer</a>";
        }
        else {
          echo "     <a href='$trailer' class='button--primary' target='_blank'>View Trailer</a>";
        }

        echo "      <!-- PHP displays Book Tickets button to logged in users over 18 only -->";
        if (isset($_SESSION['username']) && $_SESSION['userAge'] >= 18) {
          echo "    <a href='booking.php?filmID=$ID' class='button--primary'>Book Tickets</a>";
        }

        echo "    </div>";
        echo "  </div>";
        echo "</div>";
      }

      ?>

    </div>
  </section>





  <!-- Footer
  ------------------------------------->
  <footer class="footer">
    <div class="footer__container container">

      <div class="footer__nav">
        <a href="#films" class="footer__link">What's On?</a>
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