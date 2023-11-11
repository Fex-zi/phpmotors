<?php 
if (!isset($_SESSION['loggedin'])) {
  // Redirect the client to the main page if they are not logged in
  header('Location: /phpmotors/index.php');
  exit;
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
  <title>Update <?php echo $clientFirstname?> | PHP Motors</title>
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
    
<h4 class="acc"><?php if (isset($message)) { echo $message;} ?> </h4>
<h3 class="acc">Update Your Account</h3><br>

<form action="/phpmotors/accounts/index.php" method="post">
    <label for="clientFirstname" class="acc">Firstname</label><br>
      <input type="text" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?> class="acc" name="clientFirstname" id="clientFirstname" required ><br>
    <label for="clientLastname" class="acc">Lastname</label><br>
      <input type="text" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?>  class="acc" name="clientLastname" id="clientLastname" required><br>
    <label for="clientEmail" class="acc">Email</label><br>
      <input type="email" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?>   class="acc" name="clientEmail" id="clientEmail" required><br><br>
      <input type="hidden" name="action" value="updateUser">
      <input type="hidden" name="clientId" value="<?php if(isset($clientId)){echo $clientId;} ?>">
      <input type="submit" class="lgn-btn" name="submit" value="Update Account">
    </form><br>
<hr><br>
<h3 class="acc">Update Your Password</h3><br>
    <form action="/phpmotors/accounts/index.php" method="post">
    <label for="clientPassword" class="acc">Password<br> &nbsp;&nbsp;Password must be at least 8 characters with 1 uppercase character, 1 number and 1 special character.</label><br>
      <input type="password" placeholder="Enter your Password" class="acc" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br><br>
      <input type="hidden" name="action" value="updatePass">
      <input type="hidden" name="clientId" value="<?php if(isset($clientId)){echo $clientId;} ?>">
      <input type="submit" class="lgn-btn" name="submit" value="Update Password">
      </form>
</div>

</main>

<?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
