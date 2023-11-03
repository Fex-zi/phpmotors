<!-- header.php -->
<header >
    <div class="container">
    
        <div class="logo">
        <img src="/phpmotors/images/site/logo.png" alt="PHP Motors Logo" width="150">
           
        </div>
        <div class="logo2">
            <?php if (isset($_SESSION['loggedin'])) { ?> <a href="/phpmotors/accounts/?action=admin"><?php echo "<span>Welcome,  $clientFirstname </span>";  ?></a> | <a href="/phpmotors/accounts/index.php?action=logout">Logout</a> <?php } else {?> <a href="/phpmotors/accounts/index.php?action=login">My Account</a> <?php } ?>
        </div>
    </div>
</header>
