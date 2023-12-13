<?php
// Create or access a Session
session_start();
// Get the database connection file
require_once ('../library/connections.php');
// Get the PHP Motors model for use as needed
require_once ('../model/main-model.php');

require_once ('../model/accounts-model.php');

// Validation
require_once ('../library/functions.php');

//reviews model
require_once ('../model/reviews-model.php');


//view reviews
$invget = oneReview();
$invreviews = oneuserReview($invget);

// Get the array of classifications
$classifications = getClassifications();

// Navigation Function
$navList = getnavlist($classifications);

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

// Check if the user is logged in (i.e., 'loggedin' session variable is set)
if (isset($_SESSION['loggedin'])) {
  // Access the user's data from the session
  $clientData = $_SESSION['clientData'];
  // Display the user's name and email
  $clientFirstname = ucfirst($clientData['clientFirstname']);
  $clientLastname = ucfirst($clientData['clientLastname']);
  $clientEmail = $clientData['clientEmail'];
  $clientLevel = $clientData['clientLevel'];
  $clientId = $clientData['clientId'];
}


// Handle different actions based on the 'action' parameter
switch ($action) {

  case 'register':
    // Filter and store the data
      $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
      $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

      $clientEmail = checkEmail($clientEmail);
      $checkPassword = checkPassword($clientPassword);
      $existingEmail = checkExistingEmail($clientEmail);

      // Check for existing email address in the table
      if($existingEmail){
      $message = '<p style="color:red">The email address -'.$clientEmail.'- already exists. Do you want to login instead?</p>';
      include '../view/login.php';
      exit;
      }
    
    // Check for missing data
    if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
      $message = '<p style="color:red">Please provide information for all empty form fields.</p>';
      include '../view/registration.php';
      exit;
    }
    
    // Hash the checked password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    // Send the data to the model
    $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
    
    // Check and report the result
    if($regOutcome === 1){
      setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
      $_SESSION['message'] = "<p style='color:blue'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
      header('Location: /phpmotors/accounts/index.php?action=login');
      exit;
    } else {
      $message = "<p style='color:red'>Sorry $clientFirstname, the registration failed. Please try again.</p>";
      include '../view/registration.php';
      exit;
    }
    break;
    
    
case 'Login':
      // Handle login action
      $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
      $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

      $clientEmail = checkEmail($clientEmail);
      $checkPassword = checkPassword($clientPassword);
    
    // Check for missing data
    if(empty($clientEmail) || empty($checkPassword)){
      $_SESSION['message'] = '<p style="color:red">Please provide a valid email address and password.</p>';
      include '../view/login.php';
      exit;
    }
        
    // A valid password exists, proceed with the login process
    // Query the client data based on the email address
    $clientData = getClient($clientEmail);
    // Compare the password just submitted against
    // the hashed password for the matching client
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    // If the hashes don't match create an error
    // and return to the login view
    if(!$hashCheck) {
      $_SESSION['message'] = '<p style="color:red">Please check your password and try again.</p>';
      include '../view/login.php';
      exit;
    }
    // A valid user exists, log them in
    $_SESSION['loggedin'] = TRUE;
    // Remove the password from the array
    // the array_pop function removes the last
    // element from an array
    array_pop($clientData);
    // Store the array into the session
    $_SESSION['clientData'] = $clientData;
    // Send them to the admin view
    header('Location: /phpmotors/accounts/?action=admin');
    exit;

    break;

//login admin/user
case 'admin':
    
    include ('../view/admin.php');
    break;

//logout admin/user
case 'logout':
  // Unset session variables
  $_SESSION = array();
  // Destroy the session 
  session_destroy();
  header ('location: /phpmotors/index.php');
  break;


case 'updateUser':
    // Handle user update action
    
      $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL)); 
      $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

      $clientEmail = checkEmail($clientEmail);
      $existingUpdate = checkExistingupdate($clientFirstname, $clientLastname, $clientEmail);
      
      // Check for missing data
      if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientId) ){
        $message = '<p style="color:red">Please provide information for all empty form fields.</p>';
        include '../view/client-update.php';
        exit;
      }
    
      // Check for existing details in the table
      
     if($existingUpdate){
        $message = '<p style="color:red">You made no changes. Kindly update your account.</p>';
        include '../view/client-update.php';
        exit;
        }
    
    $updateOutcome = updateaccount($clientFirstname, $clientLastname, $clientEmail, $clientId);
    
    // Check and report the result
    if($updateOutcome === 1){
       // Update session data to reflect the changes
      $_SESSION['clientData']['clientFirstname'] = $clientFirstname;
      $_SESSION['clientData']['clientLastname'] = $clientLastname;
      $_SESSION['clientData']['clientEmail'] = $clientEmail;
      
      $_SESSION['message'] = "<p style='color:blue'> $clientFirstname, Your Update was Successful.</p>";
      header('Location: /phpmotors/accounts/?action=admin');
      exit;
    } else {
      $message = "<p style='color:red'>Sorry $clientFirstname, Update was Unsuccessful. Please try again.</p>";
      include '../view/client-update.php';
      exit;
    }
    break;

case 'updatePass':
    // Handle Password update action
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientID = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    $checkPassword = checkPassword($clientPassword, $clientId);
    $clientData = getClientById($clientID);
    
    // Check for missing data
    if(empty($checkPassword)){
      $message = '<p style="color:red">Password field cant be empty.</p>';
      include '../view/client-update.php';
      exit;
    }
    
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    // If the hashes don't match create an error
    // and return to the client-update view
    if($hashCheck) {
      $message = '<p style="color:red">Please, change your password.</p>';
      include '../view/client-update.php';
      exit;
    }

    // Hash the checked password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    // Send the data to the model
    $updatePass = updatepassword($hashedPassword, $clientId);
 
     // Check and report the result
    if($updatePass === 1){
     
     $_SESSION['message'] = "<p style='color:blue'> $clientFirstname, Your Password Change was Successful.</p>";
     header('Location: /phpmotors/accounts/?action=admin');
     exit;
   } else {
     $message = "<p style='color:red'>Sorry $clientFirstname, Password Change was Unsuccessful. Please try again.</p>";
     include '../view/client-update.php';
     exit;
   }
    
    break;

case 'update':
    // Handle update action
    include ('../view/client-update.php');
    break;

case 'login':
    // Handle login action
    include ('../view/login.php');
    break;

case 'registration':
    // Handle registration action
    include ('../view/registration.php');
    break;

    default:
    // Default case: Include the admin view if no valid action is specified
    include('../view/admin.php');
    break;
}
?>
