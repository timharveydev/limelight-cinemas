<?php

session_start();


// If user not logged in or under 18 or if previous URL not booking-confirmation.php,  send alert and redirect to index.php
if (!isset($_SESSION['username']) || $_SESSION['userAge'] < 18 || $_SESSION['redirect'] != '/~HNCWEBMR4/limelight-cinemas/booking-confirmation.php') {
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

$referenceCode = $age_rating . $acronym . $_GET['quantity'];

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


  <!-- Booking Confirmation Section
  ------------------------------------->

  <section class="print-confirmation">
    <div class="print-confirmation__container container">

      <!-- Confirmation box -->
      <div class="print-confirmation-box">

        <!-- Heading -->
        <h2 class="print-confirmation-box__heading">Booking Success!</h2>

        <!-- Subheading -->
        <h3 class="print-confirmation-box__subheading"><?php echo "You have booked $_GET[quantity] ticket/s to see $title." ?></h3>

        <!-- Details -->
        <p class="print-confirmation-box__details">Your booking reference code:</p>
        <p class="print-confirmation-box__details--large"><?php echo $referenceCode ?></p>
        <br><br>
        <p class="print-confirmation-box__details">Please make a note of your booking reference code as you will be required to show it on arrival at the cinema. If you provided an email address during registration, a confirmation email will be sent to you.</p>
        <br><br>
        <p class="print-confirmation-box__details">Thank you, we hope you enjoy the film!</p>
        <br><br>

        <!-- Return to homepage -->
        <a class="print-confirmation-box__return" href="index.php">Return to homepage</a>
        
      </div>

    </div>
  </section>


  <!-- END DOCUMENT
  --------------------------------------------------------->
  
</body>
</html>