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
  <title><?php echo !empty($checkRev) ? $checkRev['invMake'] . ' vehicles' : 'PHP Motors, Inc.'; ?></title>

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
<h4><?php echo $checkRev['invMake'] .'&nbsp;'. $checkRev['invModel']; ?> Reviews </h4>
<?php 
$reviewDate = date('F j, Y', strtotime($checkRev['reviewDate']));
echo "<i>Reviewed on $reviewDate </i> <p style='color:red'><i>Delete Cannot be undone. Are you sure you want to delete this review?</i></p>";
?> 
<hr>
<form action="/phpmotors/reviews/" method="post">
   <div class="creview"> <?php echo $checkRev['reviewText']; ?></div><br>
    <input type="hidden"  name="revId" value="<?php echo $checkRev['reviewId']; ?>" >
      <input type="hidden"  name="action" value="Revdelete">  
      <input type="submit" class="lgn-btn" value="Delete Review">
         
</form>
</div>
</main>

<?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
<?php unset($_SESSION['message']); ?>