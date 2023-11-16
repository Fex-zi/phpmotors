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
  <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	 echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Delete $invMake $invModel"; }?> | PHP Motors</title>
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
    <h3 class="acc"><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
elseif(isset($invMake) && isset($invModel)) { 
	echo "Delete $invMake $invModel"; }?></h3><br>
    <h3 class="acc">Confirm Vehicle Deletion. The delete is permanent..</h3><br>
<?php
if (isset($message)) {
 echo $message;
}
?>
<form action="/phpmotors/vehicles/index.php" method="post">

    <label for="invMake" class="acc">Make</label><br>
      <input type="text" id="invMake" name="invMake" class="acc" readonly <?php if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>><br><br>
    <label for="invModel" class="acc">Model</label><br>
      <input type="text"  id="invModel" name="invModel" class="acc" readonly <?php if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>><br><br>
      <label for="invDescription" class="acc">Description</label><br>
      <textarea  id="invDescription" name="invDescription" class="acc" readonly ><?php if(isset($invInfo['invDescription'])) {echo "$invInfo[invDescription]"; } ?></textarea><br><br>

      <input type="submit" class="lgn-btn" value="Delete Vehicle">
      <input type="hidden" name="action" value="deleteVehicle">
      <input type="hidden" name="invId" value="
        <?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} ?> ">
    </form>
</div>

</main>

<?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
