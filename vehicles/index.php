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
      $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
      $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
      $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    
      //get character length function for Price(float)
      //Later change back invPrice	decimal(10,2)	to invPrice	decimal(10,0)	in Database
      $error = checkCharacterLimit($invPrice, 10);
      if (!empty($error)) {
        $message = "<p style='color:red'>Price Input cannot exceed 10 characters & must be numbers.</p>";
        include '../view/add-vehicle.php';
        exit;
      }

       //get character length function for InvStock
      $error_1 = checkCharacterLimit($invStock, 6);
      if (!empty($error_1)) {
        $message = "<p style='color:red'>Instock value cannot exceed 6 characters & must be numbers.</p>";
        include '../view/add-vehicle.php';
        exit;
      }
    
    // Check for missing data n
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
      unset($invMake);
      unset($invModel);
      unset($invDescription);
      unset($invImage);
      unset($invThumbnail);
      unset($invPrice);
      unset($invStock);
      unset($invColor);
      unset($_POST['classificationId']);
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
    
    //get character length function
    $error = checkCharacterLimit($classificationName, 30);

    if (!empty($error)) {
      $message = "<p style='color:red'>Input value cannot exceed 30 characters.</p>";
      include '../view/add-classification.php';
      exit;
    }

    if(empty($classificationName)){
        $message = '<p style="color:red">Please provide Vehicle Classificaion.</p>';
        include '../view/add-classification.php';
        exit;
      }
       // Send the data to the model
    $classOutcome = addclass($classificationName);
    
    // Check and report the result
    if($classOutcome === 1){
      header ('location: ../vehicles');
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
