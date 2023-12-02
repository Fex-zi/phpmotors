<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="phpmotors">
  <meta property="og:type" content="website">
  <meta property="og:image" content="https://www.krazybutterfly.com/wp-content/uploads/2023/03/Lagos-Nigeria.jpg">
  <meta property="og:url" content="https://github.com/Fex-zi/phpmotors">
  <title><?php echo !empty($vehicles) ? $vehicles[0]['invMake'] . ' vehicles' : 'PHP Motors, Inc.'; ?></title>

  <meta name="description" content="Homepage For PhP Motors">
  <meta name="author" content="Ifeanyi Ojukwu">
  <link rel="icon" href="images/logo.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merriweather&family=Roboto&display=swap">
  <link href="../styles/base.css" rel="stylesheet" media="screen">
  <link href="../styles/larger.css" rel="stylesheet" media="screen">
  <link href="../styles/normalize.css" rel="stylesheet" media="screen">
  
  
</head>

<body style='background: url("../images/site/small_check.jpg"); background-size: cover;'>
<div class="border-bg">
<?php require_once('../includes/header.php');?>

<nav>
  <div class="container">
  <?php 
  echo $navList; 
  ?>
</div>
</nav>

<!-- other content here-->
<main>  
<div class="div1"><?php //echo $vehmake ?></div>
<?php if(isset($message)){
 echo $message; }
 ?>
 <?php if(isset($vehicleDetails)){
 echo $vehicleDetails;
} ?>

<hr>
<div class="div1">
<h4> Customer Reviews </h4>
<?php 
if (isset($_SESSION['loggedin'])) 
{ 
?>
<h4> Review the <?php echo $vehicles[0]['invMake'] .'&nbsp;'. $vehicles[0]['invModel']; ?></h4>
<?php
if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
 }
?>
<form action="/phpmotors/reviews/" method="post">
    <label for="clientName" class="acc">Screen Name:</label><br>
      <input type="text" readonly <?php $Ln = mb_substr($clientLastname, 0, 1); echo "value='$Ln$clientFirstname'"; ?> id="clientName"  class="acc"><br><br>
      
    <label for="clientReview" class="acc">Review:</label><br>
    <textarea  id="clientReview" name="clientReview" class="acc-tx" required ></textarea><br>
      <input type="submit" class="lgn-btn" value="Submit Review">
      <input type="hidden"  name="clientId" value="<?php echo $clientId; ?>" >
      <input type="hidden"  name="vehId" value="<?php echo $vehicles[0]['invId'];  ?>" >
      <input type="hidden"  name="action" value="review">     
</form>
<?php } else { ?> You must <a href="/phpmotors/accounts/index.php?action=login">Login</a> to write a review.<?php } ?>
<br><br>

<?php echo $invreviews; ?>
</div>
</main>

<?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
<?php unset($_SESSION['message']); ?>