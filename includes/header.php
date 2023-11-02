<!-- header.php -->
<header >
    <div class="container">
    
        <div class="logo">
        <img src="/phpmotors/images/site/logo.png" alt="PHP Motors Logo" width="150">
           
        </div>
        <div class="logo2">
        <a href="/phpmotors/accounts/index.php?action=login"><?php if(isset($cookieFirstname)){
 echo "<span>Welcome $cookieFirstname  | </span>";
} ?>My Account</a>
        </div>
    </div>
</header>
