<?php
session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
require_once '../model/uploads-model.php';
require_once '../library/functions.php';

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

} else {
// Redirect the client to the main page if they are not logged in
header('Location: /phpmotors/index.php');
exit;
}
/* * ****************************************************
* Variables for use with the Image Upload Functionality
* **************************************************** */
// directory name where uploaded images are stored
$image_dir = '/phpmotors/images/vehicles';
// The path is the full path from the server root
$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;

switch ($action) {
    case 'upload':
    
    // Store the incoming vehicle id and primary picture indicator
	$invId = filter_input(INPUT_POST, 'invId', FILTER_VALIDATE_INT);
	$imgPrimary = filter_input(INPUT_POST, 'imgPrimary', FILTER_VALIDATE_INT);
        
    // Store the name of the uploaded image
    $imgName = $_FILES['file1']['name'];
        
    $imageCheck = checkExistingImage($imgName);
        
    if($imageCheck){
    $message = '<p class="notice">An image by that name already exists.</p>';
    } elseif (empty($invId) || empty($imgName)) {
    $message = '<p style="color:red">You must select a vehicle and image file for the vehicle.</p>';
    } else {
    // Upload the image, store the returned path to the file
    $imgPath = uploadFile('file1');
        
    // Insert the image information to the database, get the result
    $result = storeImages($imgPath, $invId, $imgName, $imgPrimary);
        
    // Set a message based on the insert result
    if ($result) {
    $message = '<p style="color:blue">The upload succeeded.</p>';
    } else {
    $message = '<p style="color:red">Sorry, the upload failed.</p>';
    }
    }
        
    // Store message to session
    $_SESSION['message'] = $message;
      
    // Redirect to this controller for default action
    header('location: .');
    break;
    
    case 'delete':
        // Get the image name and id
    $filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $imgId = filter_input(INPUT_GET, 'imgId', FILTER_VALIDATE_INT);
        
    // Build the full path to the image to be deleted
    $target = $image_dir_path . '/' . $filename;
        
    // Check that the file exists in that location
    if (file_exists($target)) {
    // Deletes the file in the folder
    $result = unlink($target); 
    }
        
    // Remove from database only if physical file deleted
    if ($result) {
    $remove = deleteImage($imgId);
    }
        
    // Set a message based on the delete result
    if ($remove) {
    $message = "<p style='color:blue'>$filename was successfully deleted.</p>";
    } else {
    $message = "<p style='color:red'>$filename was NOT deleted.</p>";
    }
        
    // Store message to session
    $_SESSION['message'] = $message;
        
    // Redirect to this controller for default action
    header('location: .');
    break;
    
    default:
            // Call function to return image info from database
    $imageArray = getImages();
        
    // Build the image information into HTML for display
    if (count($imageArray)) {
    $imageDisplay = buildImageDisplay($imageArray);
    } else {
    $imageDisplay = '<p class="notice">Sorry, no images could be found.</p>';
    }
        
    // Get vehicles information from database
    $vehicles = getVehicles();
    // Build a select list of vehicle information for the view
    $prodSelect = buildVehiclesSelect($vehicles);
        
    include '../view/image-admin.php';
    exit;
    break;
   }

?>