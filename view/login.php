<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="phpmotors">
  <meta property="og:type" content="website">
  <meta property="og:image" content="https://www.krazybutterfly.com/wp-content/uploads/2023/03/Lagos-Nigeria.jpg">
  <meta property="og:url" content="https://github.com/Fex-zi/phpmotors">
  <title>PHP Motors | Login </title>
  <meta name="description" content="Homepage For PhP Motors">
  <meta name="author" content="Ifeanyi Ojukwu">
  <link rel="icon" href="images/logo.png">
  <link href="styles/base.css" rel="stylesheet" media="screen">
  <link href="styles/larger.css" rel="stylesheet" media="screen">
  <link href="styles/normalize.css" rel="stylesheet" media="screen">
  
  
</head>

<body style='background: url("../images/site/small_check.jpg"); background-size: cover;'>
<div class="border-bg">
<?php require_once('includes/header.php');?>

<nav>
  <div class="container">
  <?php echo $navList; ?>
</div>
</nav>

<!-- other content here-->
<main>  
  
<div class="div-lgn"> 
    <h3 class="acc">Sign In</h3><br>
<?php
if (isset($message)) {
 echo $message;
}
?>
<form action="/phpmotors/index.php" method="post">
    <label for="email" class="acc">Email</label><br>
      <input type="email" placeholder="Enter your Email" id="email" class="acc" required><br>
    <label for="password" class="acc">Password</label><br>
      <input type="password" placeholder="Enter your Password" id="password" class="acc" required><br>
      <input type="submit" class="lgn-btn" value="Sign-In">
      <input type="hidden" name="action" value="login">
    </form>
    <br>
    <a href="./index.php?action=registration" class="acc">Not a member yet? Sign-UP</a>
</div>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/includes/footer.php'; ?>
</div>
</body>
</html>
