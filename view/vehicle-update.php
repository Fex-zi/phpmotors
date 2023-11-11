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
	 echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Modify $invMake $invModel"; }?> | PHP Motors</title>
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
	echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
elseif(isset($invMake) && isset($invModel)) { 
	echo "Modify $invMake $invModel"; }?></h3><br>

<?php
if (isset($message)) {
 echo $message;
}
?>
<form action="/phpmotors/vehicles/index.php" method="post">

<select name="classificationId" id="classificationId" required>
    <option value="" disabled selected>Choose Car Classifications</option>
    <?php
    foreach ($classifications as $classification) {
        $selected = '';
        if (isset($_POST['classificationId']) && $_POST['classificationId'] == $classification['classificationId']) {
            $selected .= 'selected';
        }
        elseif(isset($invInfo['classificationId'])){
            if($classification['classificationId'] === $invInfo['classificationId']){
            $selected .= ' selected ';
            }}
        ?>
        <option value="<?= $classification['classificationId'] ?>" <?= $selected ?>>
            <?= $classification['classificationName'] ?>
        </option>
    <?php
    } ?>
</select>
<br><br><br>

    <label for="invMake" class="acc">Make</label><br>
      <input type="text" id="invMake" name="invMake" class="acc" required <?php if(isset($invMake)){echo "value='$invMake'";} elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>><br><br>
    <label for="invModel" class="acc">Model</label><br>
      <input type="text"  id="invModel" name="invModel" class="acc" required <?php if(isset($invModel)){echo "value='$invModel'";} elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>><br><br>
      <label for="invDescription" class="acc">Description</label><br>
      <textarea  id="invDescription" name="invDescription" class="acc" required ><?php if(isset($invDescription)){echo "$invDescription";} elseif(isset($invInfo['invDescription'])) {echo "$invInfo[invDescription]"; } ?></textarea><br><br>
      <label for="invImage" class="acc">Image Path</label><br>
      <input type="text" id="invImage" name="invImage" class="acc" required <?php if(isset($invImage)){echo "value='$invImage'";} elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'"; }?>><br><br>
    <label for="invThumbnail" class="acc">Thumbnail Path</label><br>
      <input type="text"  id="invThumbnail" name="invThumbnail" class="acc" required <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";} elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'"; }?>><br><br>
      <label for="invPrice" class="acc">Price(0-10 digits)</label><br>
      <input type="text" id="invPrice" name="invPrice" class="acc" required <?php if(isset($invPrice)){echo "value='$invPrice'";} elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; }?>><br><br>
    <label for="invStock" class="acc"># In Stock(0-6 digits)</label><br>
      <input type="text"  id="invStock" name="invStock" class="acc" required <?php if(isset($invStock)){echo "value='$invStock'";} elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; }?>><br><br>
      <label for="invColor" class="acc">Color</label><br>
      <input type="text"  id="invColor" name="invColor" class="acc" required <?php if(isset($invColor)){echo "value='$invColor'";} elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; }?>><br>

      <input type="submit" class="lgn-btn" value="Update Vehicle">
      <input type="hidden" name="action" value="updateVehicle">
      <input type="hidden" name="invId" value="
        <?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
        elseif(isset($invId)){ echo $invId; } ?>
        ">
    </form>
</div>

</main>

<?php include '../includes/footer.php'; ?>
</div>
</body>
</html>
