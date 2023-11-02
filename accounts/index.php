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


// Get the array of classifications
$classifications = getClassifications();

// Navigation Function
$navList = getnavlist($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

// Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cookieFirstname = ucfirst($cookieFirstname);
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
      header('Location: /phpmotors/accounts/?action=login');
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
      $message = '<p style="color:red">Please provide a valid email address and password.</p>';
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
      $message = '<p class="notice">Please check your password and try again.</p>';
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
    // Handle login action
    include ('../view/admin.php');
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
    // Default case: Include the login view if no valid action is specified
    include('../view/login.php');
    break;
}
?>
