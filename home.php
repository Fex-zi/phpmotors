
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="phpmotors">
  <meta property="og:type" content="website">
  <meta property="og:image" content="https://www.krazybutterfly.com/wp-content/uploads/2023/03/Lagos-Nigeria.jpg">
  <meta property="og:url" content="https://github.com/Fex-zi/phpmotors">
  <title>PHP Motors | Home </title>
  <meta name="description" content="Homepage For PhP Motors">
  <meta name="author" content="Ifeanyi Ojukwu">
  <link rel="icon" href="images/logo.png">
  <link href="styles/base.css" rel="stylesheet" media="screen">
  <link href="styles/larger.css" rel="stylesheet" media="screen">
  <link href="styles/normalize.css" rel="stylesheet" media="screen">
  
  
</head>

<body style='background: url("images/site/small_check.jpg"); background-size: cover;'>
<div class="border-bg">
<?php require_once('includes/header.php');?>

<?php require_once('includes/navigation.php'); ?>

<!-- other content here-->
<main>  
 <div class="div1">Welcome to PHP Motors !</div>

 <div class="div2"> 
  <div class="side">
    <p><b>DMC Delorean</b></p>
    <p>3 Cup Holders</p>
    <p>Superman doors</p>
    <p>Fuzzy dice!</p>
    <button class="cta-btn">Own Today</button>
  </div>
  <img src="images/delorean.jpg" alt="This is an image of delorean"> 
 </div>
   
 <div class="div3">
      <button class="cta-btn2">Own Today</button>
        <div class="box">
          <h1>Delorean Upgrades</h1>
            <div><img src="images/upgrades/flux-cap.png" alt="This is an image of Flux Capacitor"><p><a href="#">Flux Capacitor</a></p></div>
            <div><img src="images/upgrades/flame.jpg" alt="This is an image of Flame Decals"><p><a href="#">Flame Decals</a></p></div>
            <br>
            <div><img src="images/upgrades/bumper_sticker.jpg" alt="This is an image of Bumper Stickers"><p><a href="#">Bumper Stickers</a></p></div>
            <div><img src="images/upgrades/hub-cap.jpg" alt="This is an image of Hub Caps"><p><a href="#">Hub Caps</a></p></div>
        </div>
          <br>
        <div class="box"><h1>DMC Delorean Reviews</h1>
          <br>
          <p class="box-p1">&bull; "So fast its almost like traveling in time."  [4/5]</p>
          <p class="box-p1">&bull; "Coolest ride on the road."  [4/5]</p>
          <p class="box-p1">&bull; "I'm feeling Marty McFly!"  [5/5] </p>
          <p class="box-p1">&bull; "The most futuristic ride of our day."  [4.5/5]</p>
          <p class="box-p1">&bull; "80's livin and I love it!"  [5/5]</p>

        </div>
 </div>

</main>
<!-- End content here-->

<?php require_once('includes/footer.php'); ?> 
</div>
</body>
</html>
