<?php
// Get the database connection file
require_once ('library/connections.php');
// Get the PHP Motors model for use as needed
require_once ('model/main-model.php');


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
    case 'Used':
        
        include('view/used.php');
        break;

    case 'Classic':
        
        include('view/classic.php');
        break;

     case 'Sports':
       
        include('view/sports.php');
        break;

    case 'SUV':
        
        include('view/suv.php');
        break;

     case 'Trucks':
       
        include('view/trucks.php');
        break;

    default:
        // Default case: Include the home view if no valid action is specified
        include('view/home.php');
        break;
}
?>
