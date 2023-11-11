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
  <?php echo $navList; ?>
</div>
</nav>

<!-- other content here-->
<main>  
  
<div class="div-lgn"> 
    <h3 class="acc">Sign In</h3><br>
<?php
if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
 }
?>
<form action="/phpmotors/accounts/index.php" method="post">
    <label for="clientEmail" class="acc">Email</label><br>
      <input type="email" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> id="clientEmail" name="clientEmail" class="acc" required><br><br>
    <label for="clientPassword" class="acc">Password<br> &nbsp;&nbsp;Password must be at least 8 characters with 1 uppercase character, 1 number and 1 special character.</label><br>
      <input type="password" id="clientPassword" name="clientPassword" class="acc" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
      <input type="submit" class="lgn-btn" value="Sign-In">
      <input type="hidden" name="action" value="Login">
    </form>
    <br>
    <a href="?action=registration" class="acc">Not a member yet? Sign-UP</a>
</div>

</main>

<?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
<?php unset($_SESSION['message']); ?>