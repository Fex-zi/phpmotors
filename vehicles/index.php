<?php
// Get the database connection file
require_once ('../library/connections.php');
// Get the PHP Motors model for use as needed
require_once ('../model/main-model.php');

require_once ('../model/vehicles-model.php');

//get functions
require_once ('../library/functions.php');


// Get the array of classifications
$classifications = getClassifications();

// Navigation Function
$navList = getnavlist($classifications);


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

// Handle different actions based on the 'action' parameter
switch ($action) {

case 'register':
    // Filter and store the data
      $invMake = trim(filter_input(INPUT_POST, 'invMake'));
      $invModel = trim(filter_input(INPUT_POST, 'invModel'));
      $invDescription = trim(filter_input(INPUT_POST, 'invDescription'));
      $invImage = trim(filter_input(INPUT_POST, 'invImage'));
      $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail'));
      $invPrice = trim(filter_input(INPUT_POST, 'invPrice'));
      $invStock = trim(filter_input(INPUT_POST, 'invStock'));
      $invColor = trim(filter_input(INPUT_POST, 'invColor'));
      $classificationId = trim(filter_input(INPUT_POST, 'classificationId'));
    
    // Check for missing data
    if(empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)){
      $message = '<p style="color:red">Please provide all the missing fields.</p>';
      include '../view/add-vehicle.php';
      exit;
    }
    
    // Send the data to the model
    $regOutcome = addvehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
    
    // Check and report the result
    if($regOutcome === 1){
      $message = "<p style='color:Blue'>Your Vehicle '$invMake - $invModel' has been added successfully.</p>";
      include '../view/add-vehicle.php';
      exit;
    } else {
      $message = "<p style='color:red'>Sorry Vehicle registration failed. Please try again.</p>";
      include '../view/add-vehicle.php';
      exit;
    }
    break;

//create Vehicle classification
case 'class':
    $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    if(empty($classificationName)){
        $message = '<p style="color:red">Please provide Vehicle Classificaion.</p>';
        include '../view/add-classification.php';
        exit;
      }
       // Send the data to the model
    $classOutcome = addclass($classificationName);
    
    // Check and report the result
    if($classOutcome === 1){
      include ('../view/vehicle-man.php');
      exit;
    } else {
      $message = "<p style='color:red'>Sorry the registration failed. Please try again.</p>";
      include '../view/add-classification.php';
      exit;
    }
    break;

case 'classification':
    // Handle class action
    include ('../view/add-classification.php');
    break;

case 'vehicle':
    // Handle vehicle action
    include ('../view/add-vehicle.php');
    break;

    default: 
    include ('../view/vehicle-man.php');
    break;
}
?>
