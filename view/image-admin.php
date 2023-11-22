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
  <title>Image Management | PHP Motors, Inc.</title>
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
<div class="div1"><b><?php //echo $classificationName; ?></b></div>
<?php 
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
   }
 ?>
 <h2>Add New Vehicle Image</h2>
<?php
 if (isset($message)) {
  echo $message;
 } ?>

<form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data">
 <label for="invItem">Vehicle</label>
	<?php echo $prodSelect; ?>
	<fieldset>
		<label>Is this the main image for the vehicle?</label>
		<label for="priYes" class="pImage">Yes</label>
		<input type="radio" name="imgPrimary" id="priYes" class="pImage" checked value="1">
		<label for="priNo" class="pImage">No</label>
		<input type="radio" name="imgPrimary" id="priNo" class="pImage"  value="0">
	</fieldset>
 <label>Upload Image:</label>
 <input type="file" name="file1">
 <input type="submit" class="regbtn" value="Upload">
 <input type="hidden" name="action" value="upload">
</form>
<hr>
<h2>Existing Images</h2>
<p style="color:red;">If deleting an image, delete the thumbnail too and vice versa.</p>
<?php
 if (isset($imageDisplay)) {
  echo $imageDisplay;
 } ?>
</main>

<?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
<?php unset($_SESSION['message']); ?>