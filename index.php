<?php
// Create or access a Session
session_start();
// Get the database connection file
require_once ('library/connections.php');
// Get the PHP Motors model for use as needed
require_once ('model/main-model.php');

require_once ('model/accounts-model.php');
//get functions
require_once ('library/functions.php');


// Get the array of classifications
$classifications = getClassifications();

// Navigation Function
$navList = getnavlist($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

/* Check if the firstname cookie exists, get its value
if(isset($_SESSION['firstname'])){
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cookieFirstname = ucfirst($cookieFirstname);
 }
 */

 // Check if the user is logged in (i.e., 'loggedin' session variable is set)
if (isset($_SESSION['loggedin'])) {
  // Access the user's data from the session
  $clientData = $_SESSION['clientData'];
  // Display the user's details
  $clientFirstname = ucfirst($clientData['clientFirstname']);
  $clientLastname = ucfirst($clientData['clientLastname']);
  $clientEmail = $clientData['clientEmail'];
  $clientLevel = $clientData['clientLevel'];
}

 
// Handle different actions based on the 'action' parameter
switch ($action) {
  // Code to deliver the views will be here

    case 'Used':
        
        include('view/used.php');
        break;

    case 'Classic':
        
        include('view/classic.php');
        break;

     case 'Sports':
       
        include('view/sports.php');
        break;

    case 'SUV':
        
        include('view/suv.php');
        break;

     case 'Trucks':
       
        include('view/trucks.php');
        break;
      
     case 'error':
          // Handle error action
        include ('view/500.php');
        break;

    default:
        // Default case: Include the home view if no valid action is specified
        include('view/home.php');
        break;
}
?>
