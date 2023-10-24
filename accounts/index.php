<?php
// Get the database connection file
require_once ('../library/connections.php');
// Get the PHP Motors model for use as needed
require_once ('../model/main-model.php');

require_once ('../model/accounts-model.php');

// Validation
require_once ('../library/functions.php');


// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = '<ul>';
$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
  $navList .= "<li><a href='/phpmotors/index.php?action=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
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
      $message = "<p style='color:red'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
      include '../view/login.php';
      exit;
    } else {
      $message = "<p style='color:red'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
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
      $message = '<p style="color:red">Please provide information for all empty form fields.</p>';
      include '../view/login.php';
      exit;
    }
    //include ('../view/login.php');
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
