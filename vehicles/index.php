<?php
// Get the database connection file
require_once ('../library/connections.php');
// Get the PHP Motors model for use as needed
require_once ('../model/main-model.php');

require_once ('../model/vehicles-model.php');


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
      $invMake = filter_input(INPUT_POST, 'invMake');
      $invModel = filter_input(INPUT_POST, 'invModel');
      $invDescription = filter_input(INPUT_POST, 'invDescription');
      $invImage = filter_input(INPUT_POST, 'invImage');
      $invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
      $invPrice = filter_input(INPUT_POST, 'invPrice');
      $invStock = filter_input(INPUT_POST, 'invStock');
      $invColor = filter_input(INPUT_POST, 'invColor');
      $classificationId = filter_input(INPUT_POST, 'classificationId');
    
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
    $classificationName = filter_input(INPUT_POST, 'classificationName');
    if(empty($classificationName)){
        $message = '<p style="color:red">Please provide Vehicle Classificaion.</p>';
        include '../view/add-classification.php';
        exit;
      }
       // Send the data to the model
    $classOutcome = addclass($classificationName);
    
    // Check and report the result
    if($classOutcome === 1){
      include '../view/add-classification.php';
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
    header ('location: ../view/vehicle-man.php');
    break;
}
?>
