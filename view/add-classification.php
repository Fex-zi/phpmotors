<?php
if ($clientLevel <= 1) {
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
  <title>PHP Motors | Add-Classification </title>
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
    <h3 class="acc">Add Car Classification</h3><br>
    <?php
if (isset($message)) {
 echo $message;
}
?>

<form action="/phpmotors/vehicles/index.php" method="post">
    <label for="classificationName" class="acc">Classification Name</label><br><div style="color:red">&nbsp;&nbsp;Not more than 30 characters</div><br>
      <input type="text" id="classificationName" name="classificationName" class="acc" <?php if(isset($classificationName)){echo "value='$classificationName'";} ?>required><br>
      <input type="submit" class="lgn-btn" value="Add Classification">
      <input type="hidden" name="action" value="class">
    </form>
    <br>
</div>

</main>

<?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
