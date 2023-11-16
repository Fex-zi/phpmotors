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
      $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
      $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
      $dv .= "<span>$formattedPrice</span>";
      $dv .= '</li></a>';
      
  }
  
  $dv .= '</ul>';
  return $dv;
}

// vehicles Details view.
function VehiclesDetails($vehicles) {
  $dv = '<ul class="inv-details">';

  foreach ($vehicles as $vehicle) {
      $formattedPrice = '$' . number_format($vehicle['invPrice'], 0, '.', ',');

      $dv .= "<li class='vehicle-details'>";
      $dv .= "<div class='image-container'>";
      $dv .= "<img src='{$vehicle['invImage']}' alt='Image of {$vehicle['invMake']} {$vehicle['invModel']} on phpmotors.com'>";
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

?>