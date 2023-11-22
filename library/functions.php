<?php

//check Email
function checkEmail($clientEmail){
 $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
 return $valEmail;
}

//check Password
function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}

// Build a navigation bar using the $classifications array
function getnavlist($classifications){

$navList = '<ul>';
$navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
  $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';
return $navList;
}

//maxlenght code
function checkCharacterLimit($inputValue, $maxLength) {
  if (strlen($inputValue) > $maxLength) {
      return "Input value cannot exceed $maxLength characters.";
  } else {
      return ''; // No error; input is within the character limit.
  }
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
  $classificationList = '<select name="classificationId" id="classificationList">'; 
  $classificationList .= "<option>Choose a Classification</option>"; 
  foreach ($classifications as $classification) { 
   $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
  } 
  $classificationList .= '</select>'; 
  return $classificationList; 
 }


 //build a display of vehicles within an unordered list.
 function buildVehiclesDisplay($vehicles){
   $dv = '<ul id="inv-display">';
  
  foreach ($vehicles as $vehicle) {
      $formattedPrice = '$' . number_format($vehicle['invPrice'], 0, '.', ',');
      
      $dv .= "<a href='/phpmotors/vehicles/?action=vehDetails&vehId=$vehicle[invId]'><li>";
      $dv .= "<img src='$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
      $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
      $dv .= "<span>$formattedPrice</span>";
      $dv .= '</li></a>';
      
  }
  
  $dv .= '</ul>';
  return $dv;
}

//Get vehicle details
function VehiclesDetails($vehicles, $vehicles_tn) {
  $dv = '<ul class="inv-details">';

  foreach ($vehicles as $vehicle) {
      $formattedPrice = '$' . number_format($vehicle['invPrice'], 0, '.', ',');

      $dv .= "<li class='vehicle-details'>";

      // Display thumbnail images
      $dv .= "<div class='thumbnail-container'>";

      foreach ($vehicles_tn as $vehicle_tn) {
          $dv .= "<img src='{$vehicle_tn['imgPath']}' alt='Thumbnail'>";
      }

      $dv .= "</div>";

      $dv .= "<div class='image-container'>";
      $dv .= "<img src='{$vehicle['imgPath']}' alt='Image of {$vehicle['invMake']} {$vehicle['invModel']} on phpmotors.com'>";
      $dv .= "</div>";
      $dv .= "<div class='description-container'>";
      $dv .= "<h2>{$vehicle['invMake']} {$vehicle['invModel']}</h2>";
      $dv .= "<span>{$formattedPrice}</span>";
      $dv .= "</div>";
      $dv .= "<div class='description-container-right'>";
      $dv .= "<hr><h3>{$vehicle['invMake']} {$vehicle['invModel']} Details</h3>";
      $dv .= "<p>{$vehicle['invDescription']}</p>";
      $dv .= "<p>Color: {$vehicle['invColor']}</p>";
      $dv .= "<p>#Inv in Stock: {$vehicle['invStock']}</p>";
      $dv .= "</div>";

      $dv .= '</li>';
  }

  $dv .= '</ul>';
  return $dv;
}



/* * ********************************
*  Functions for working with images
* ********************************* */
// Adds "-tn" designation to file name
function makeThumbnailName($image) {
  $i = strrpos($image, '.');
  $image_name = substr($image, 0, $i);
  $ext = substr($image, $i);
  $image = $image_name . '-tn' . $ext;
  return $image;
 }

 // Build images display for image management view
function buildImageDisplay($imageArray) {
  $id = '<ul id="inv-display">';
  foreach ($imageArray as $image) {
   $id .= '<li>';
   $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
   $id .= "<p style='color:red;'><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
   $id .= '</li>';
 }
  $id .= '</ul>';
  return $id;
 }

 // Build the vehicles select list
function buildVehiclesSelect($vehicles) {
  $prodList = '<select name="invId" id="invId">';
  $prodList .= "<option>Choose a Vehicle</option>";
  foreach ($vehicles as $vehicle) {
   $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
  }
  $prodList .= '</select>';
  return $prodList;
 }

 // Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
  // Gets the paths, full and local directory
  global $image_dir, $image_dir_path;
  if (isset($_FILES[$name])) {
   // Gets the actual file name
   $filename = $_FILES[$name]['name'];
   if (empty($filename)) {
    return;
   }
  // Get the file from the temp folder on the server
  $source = $_FILES[$name]['tmp_name'];
  // Sets the new path - images folder in this directory
  $target = $image_dir_path . '/' . $filename;
  // Moves the file to the target folder
  move_uploaded_file($source, $target);
  // Send file for further processing
  processImage($image_dir_path, $filename);
  // Sets the path for the image for Database storage
  $filepath = $image_dir . '/' . $filename;
  // Returns the path where the file is stored
  return $filepath;
  }
 }
?>