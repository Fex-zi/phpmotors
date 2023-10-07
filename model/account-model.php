<?php


$action = filter_input(INPUT_GET, 'action');

switch ($action) {
    case 'login':
        // Handle login action
        include '../view/login.php';
        break;

    case 'registration':
        // Handle registration action
        include '../view/registration.php';
        break;

    default:
        // Default to home view
        include './index.php';
        break;
}
?>
