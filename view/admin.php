<?php 
if (!isset($_SESSION['loggedin'])) 
{ 
    header('Location: /phpmotors/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="phpmotors">
  <meta property="og:type" content="website">
  <meta property="og:image" content="https://www.krazybutterfly.com/wp-content/uploads/2023/03/Lagos-Nigeria.jpg">
  <meta property="og:url" content="https://github.com/Fex-zi/phpmotors">
  <title>Vehicle Management  </title>
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
  
<div class="div1"> 
<?php
 if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
 } 
 ?>

<?php echo "Welcome,  $clientFirstname  $clientLastname"; ?>
<h5>You are Logged in: </h5>

<p class="box-p1">&bull; Firstname : <?php echo $clientFirstname; ?></p>
<p class="box-p1">&bull; Lastname : <?php echo $clientLastname; ?></p>
<p class="box-p1">&bull; Email : <?php echo $clientEmail; ?></p>
<hr>
<h5>Account Management</h5>
<p> Use this link below to update account information.</p>
<h5><a href="?action=update" class="acc">Update Account Information</a></h5>

<?php if($clientLevel==3) { ?>
  <hr>
<h5>Inventory Management</h5>
 <p>Use this link below to manage the inventory.</p>
<h5><a href="/phpmotors/vehicles/" class="acc">Vehicle Management</a></h5>

<?php } ?>

<hr>
<h5>Manage Your Product Reviews</h5>
<p> Use this link below to update product review.</p>
<?php if(isset($invreviews)) {echo $invreviews;} ?>

</div>

</main>

<?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
<?php unset($_SESSION['message']); ?>