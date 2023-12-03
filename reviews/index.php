<?php
// Create or access a Session
session_start();
// Get the database connection file
require_once ('../library/connections.php');
// Get the PHP Motors model for use as needed
require_once ('../model/main-model.php');

require_once ('../model/vehicles-model.php');

//get functions
require_once ('../library/functions.php');

//uploads model
require_once ('../model/uploads-model.php');

//reviews model
require_once ('../model/reviews-model.php');


// Get the array of classifications
$classifications = getClassifications();

// Navigation Function
$navList = getnavlist($classifications);

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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

      case 'review':
        $VehicleID = filter_input(INPUT_POST, 'vehId', FILTER_SANITIZE_NUMBER_INT);
        $ClientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $ClientReview = filter_input(INPUT_POST, 'clientReview', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        
        if (empty($VehicleID) || empty($ClientId) || empty($ClientReview)) {
        $message2 = '<p style="color:red"><i>Review cant be empty.</i></p>';
        $_SESSION['message'] = $message2;
        header ("location: /phpmotors/vehicles/?action=vehDetails&vehId=".$VehicleID."");        
        exit; 
      }
       
      $VehReview = Addreview($ClientReview,$VehicleID,$ClientId);
        
        if(!$VehReview)
        {
          $message2 = "<p style='color:red'><i>Sorry, Review couldn't be added, Retry again!!!</i></p>";  
          $_SESSION['message'] = $message2;
          header ("location: /phpmotors/vehicles/?action=vehDetails&vehId=".$VehicleID."");        
          exit;   
        }
        else{
          $message2 = "<p style='color:blue'><i>Thanks for the review, it's displayed below.</i></p>";
          $_SESSION['message'] = $message2;
          header ("location: /phpmotors/vehicles/?action=vehDetails&vehId=".$VehicleID."");
         exit;
        }       
        break;

     //Update Review view
     case 'updateReview':
      $Reviewbyid = filter_input(INPUT_GET, 'rivId', FILTER_SANITIZE_NUMBER_INT);

      if (empty($Reviewbyid)) {
        header ("location:/phpmotors/accounts/?action=admin");    
        exit; 
      }

      $checkRev = oneReviewview($Reviewbyid);

      if (!$checkRev) {
        header ("location:/phpmotors/accounts/?action=admin");    
        exit; 
      }

      include ('../view/review-update.php');
      break;
    

     //update contoller
     case 'update':
     $Review = filter_input(INPUT_POST, 'revId', FILTER_SANITIZE_NUMBER_INT, FILTER_VALIDATE_INT);
     $reviewtxt = filter_input(INPUT_POST, 'clientReview', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    

     if (empty($Review) || empty($reviewtxt)) {
      $_SESSION['message'] = "<p style='color:red'>Review Can't be Empty</p>";
      header ("location:/phpmotors/reviews/?action=updateReview&rivId=".$Review."");    
      exit; 
     }

     $check = checkExistingReview($reviewtxt);
     if ($check){
      $_SESSION['message'] = "<p style='color:red'>You didn't make any changes yet!!!</p>";
      header ("location:/phpmotors/reviews/?action=updateReview&rivId=".$Review.""); 
      exit; 
     }

     $updater = updatereview($reviewtxt, $Review);
     if($updater){
      $_SESSION['message'] = "<p style='color:blue'>Review Update was Successful</p>";
      header ("location:/phpmotors/accounts/?action=admin");    
      exit; 
     } else{
      $_SESSION['message'] = "<p style='color:red'>Review Update was unsuccessful</p>";
      header ("location:/phpmotors/reviews/?action=updateReview&rivId=".$Review.""); 
      exit;  
     }
     break;


     //delete contoller view
     case 'delete':
      $Reviewbyid = filter_input(INPUT_GET, 'rivId', FILTER_SANITIZE_NUMBER_INT);

      if (empty($Reviewbyid)) {
        header ("location:/phpmotors/accounts/?action=admin");    
        exit; 
      }
      $checkRev = oneReviewview($Reviewbyid);

      if (!$checkRev) {
        header ("location:/phpmotors/accounts/?action=admin");    
        exit; 
      }
      include ('../view/review-delete.php');
      break;
  
     //delete contoller
     case 'Revdelete':
      $Review = filter_input(INPUT_POST, 'revId', FILTER_SANITIZE_NUMBER_INT, FILTER_VALIDATE_INT);
      
      if (empty($Review)) {
       $_SESSION['message'] = "<p style='color:red'>Review Empty</p>";
       header ("location:/phpmotors/reviews/?action=delete&rivId=".$Review."");    
       exit; 
      }
 
      $updater = deleteReview($Review);
      if($updater){
       $_SESSION['message'] = "<p style='color:blue'>Review Delete was Successful</p>";
       header ("location:/phpmotors/accounts/?action=admin");    
       exit; 
      } else{
       $_SESSION['message'] = "<p style='color:red'>Review Delete was unsuccessful</p>";
       header ("location:/phpmotors/reviews/?action=delete&rivId=".$Review.""); 
       exit;  
      }
      break;


     case 'error':
          // Handle error action
        include ('../view/500.php');
        break;

    default:
        // Default case: Include the home view if no valid action is specified
        header ("location:/phpmotors/accounts/?action=admin");
        break;
}
?>
