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
$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
  $navList .= "<li><a href='/phpmotors/index.php?action=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
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
?>