<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="phpmotors">
  <meta property="og:type" content="website">
  <meta property="og:image" content="https://www.krazybutterfly.com/wp-content/uploads/2023/03/Lagos-Nigeria.jpg">
  <meta property="og:url" content="https://github.com/Fex-zi/phpmotors">
  <title>PHP Motors | User Register </title>
  <meta name="description" content="Homepage For PhP Motors">
  <meta name="author" content="Ifeanyi Ojukwu">
  <link rel="icon" href="images/logo.png">
  <link href="styles/base.css" rel="stylesheet" media="screen">
  <link href="styles/larger.css" rel="stylesheet" media="screen">
  <link href="styles/normalize.css" rel="stylesheet" media="screen">
  
  
</head>

<body style='background: url("./images/site/small_check.jpg"); background-size: cover;'>
<div class="border-bg">
<?php require_once('includes/header.php');?>

<?php //require_once('includes/navigation.php'); ?>
<nav>
  <div class="container">
  <?php echo $navList; ?>
</div>
</nav>
<main>  
  
<div class="div-lgn"> 
    <h2 class="acc">Register</h2><br>
    <?php
if (isset($message)) {
 echo $message;
}
?>
    <form method="post" action="/phpmotors/index.php">
    <label for="firstname" class="acc">Firstname</label><br>
      <input type="text" placeholder="Enter your firstname" class="acc" name="clientFirstname"><br>
    <label for="lastname" class="acc">Lastname</label><br>
      <input type="text" placeholder="Enter your lastname" class="acc" name="clientLastname"><br>
    <label for="email" class="acc">Email</label><br>
      <input type="email" placeholder="Enter your Email"  class="acc" name="clientEmail"><br>
    <label for="password" class="acc">Password</label><br>
      <input type="password" placeholder="Enter your Password" class="acc" name="clientPassword"><br>
      <input type="submit" class="lgn-btn" name="submit" value="Register">
      <input type="hidden" name="action" value="register">
    </form>
    <br>
    
</div>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/includes/footer.php'; ?>
</div>
</body>
</html>
