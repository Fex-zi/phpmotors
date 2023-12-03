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

//add reviews
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

 // Check if the user is logged in and Clientlevel is >1 (i.e., 'loggedin' session variable is set)
 if (isset($_SESSION['loggedin'])) {
      // Access the user's data from the session
      $clientData = $_SESSION['clientData'];
  
      // Check if the client's level is greater than 1
      $clientLevel = $clientData['clientLevel'];
      // Display the user's details
      $clientFirstname = ucfirst($clientData['clientFirstname']);
      $clientLastname = ucfirst($clientData['clientLastname']);
      $clientEmail = $clientData['clientEmail'];
      $clientId = $clientData['clientId'];
 
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

    //unset form
    unset($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $_POST['classificationId']);

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

case 'addclassification':
    // Handle class action
    include ('../view/add-classification.php');
    break;
    
case 'getInventoryItems': 
 // Get the classificationId 
 $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT,  FILTER_VALIDATE_INT); 
 // Fetch the vehicles by classificationId from the DB 
 $inventoryArray = getInventoryByClassification($classificationId); 
 // Convert the array to a JSON object and send it back 
 echo json_encode($inventoryArray); 
 break;

case 'mod':
 $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT, FILTER_VALIDATE_INT);
 $invInfo = getInvItemInfo($invId);

 //if invId is wrong
 if (!$invInfo) {
  header ("location:/phpmotors/accounts/?action=admin");    
  exit; 
}
 if(count($invInfo)<1){
  $message = 'Sorry, no vehicle information could be found.';
 }
 include '../view/vehicle-update.php';
 exit;
break;

case 'updateVehicle':
	$classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
	$invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
	$invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
	
	if (empty($classificationId) || empty($invMake) || empty($invModel) 
    || empty($invDescription) || empty($invImage) || empty($invThumbnail)
    || empty($invPrice) || empty($invStock) || empty($invColor)) {
  $message = '<p style="color:red">Please complete all information for the item! Double check the classification of the item.</p>';
	 include '../view/vehicle-update.php';
 exit;
}

$updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
if ($updateResult) {
 $message = "<p style='color:blue'>Congratulations, the $invMake $invModel was successfully updated.</p>";
	$_SESSION['message'] = $message;
	header('location: /phpmotors/vehicles/');
	exit;
} else {
	$message = "<p style='color:red'>Error. the $invMake $invModel was not updated.</p>";
	 include '../view/vehicle-update.php';
	 exit;
	}
break;

case 'del':
  $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
  $invInfo = getInvItemInfo($invId);
  if (count($invInfo) < 1) {
      $message = 'Sorry, no vehicle information could be found.';
    }
    include '../view/vehicle-delete.php';
    exit;
    break;

case 'deleteVehicle':
$invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

$deleteResult = deleteVehicle($invId);
if ($deleteResult) {
	$message = "<p style='color:blue'>Congratulations the $invMake $invModel was	successfully deleted.</p>";
	$_SESSION['message'] = $message;
	header('location: /phpmotors/vehicles/');
	exit;
} else {
	$message = "<p style='color:red'>Error: $invMake $invModel was not
deleted.</p>";
	$_SESSION['message'] = $message;
	header('location: /phpmotors/vehicles/');
	exit;
}
break;

case 'vehicle':
    // Handle vehicle action
    include ('../view/add-vehicle.php');
    break;

case 'classification':
 $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 $vehicles = getVehiclesByClassification($classificationName);
 if(!count($vehicles)){
  $message = "<p style='color:red'>Sorry, no $classificationName could be found.</p>";
 } else {
  $vehicleDisplay = buildVehiclesDisplay($vehicles);
  //echo $vehicleDisplay;
  include '../view/classification.php';
  exit;
 }
 break;


 case 'vehDetails':
  $VehicleID = filter_input(INPUT_GET, 'vehId', FILTER_SANITIZE_NUMBER_INT);
  $vehicles = getVehiclesByClassification2($VehicleID);
  $vehicles_tn = getThumbnailsByVehicleId($VehicleID);
  $invget = viewReview($VehicleID);
  
  
  
  if(!count($vehicles)){
    $message = "<p style='color:red'>Sorry, no Vehicle could be found.</p>";
   } else {
    $vehicleDetails = VehiclesDetails($vehicles, $vehicles_tn);
    $invreviews = vehicleReview($invget);
    include ('../view/vehicle-detail.php');
    exit;
   }
  break;

    default: 
    $classificationList = buildClassificationList($classifications);

    include ('../view/vehicle-man.php');
    break;
}


?>
