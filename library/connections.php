<?php 

function phpmotorsConnect(){
 $password = ''; 
 $server = 'Localhost';
 $dbname= 'phpmotors';
 $username = 'root';

 
 $dsn = "mysql:host=$server;dbname=$dbname";
 $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

 // Create the actual connection object and assign it to a variable
 try {
  $link = new PDO($dsn, $username, $password, $options);
  return $link;
 } catch(PDOException $e) {

  header('Location: /phpmotors/index.php?action=error');
  exit;
 }
}

?>
<?php phpmotorsConnect(); ?>