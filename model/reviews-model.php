<?php

   function Addreview($Rtext,$invid,$cId) {
    $db = phpmotorsConnect();

    $sql = 'INSERT INTO reviews(`reviewText`, `invId`, `clientId`)  VALUES (:revtxt, :ivid, :clid)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':revtxt', $Rtext, PDO::PARAM_STR);
    $stmt->bindValue(':ivid', $invid, PDO::PARAM_INT);
    $stmt->bindValue(':clid', $cId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function viewReview($invId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT r.*, c.clientId, c.clientFirstname, c.clientLastname, i.invId, i.invMake, i.invModel, i.classificationId
            FROM reviews r
            JOIN clients c ON r.clientId = c.clientId
            JOIN inventory i ON r.invId = i.invId
            WHERE r.invId = :invId
            ORDER BY r.reviewId DESC';
    
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}

//get review based on loggedin user
function oneReview()
{    
    //function is from library/functions.php
    $clientId = getCurrentUserId();
    //$clientId = $_SESSION['clientData']['clientId'];
    $db = phpmotorsConnect();
    $sql = 'SELECT r.*, c.clientId, c.clientFirstname, c.clientLastname, i.invId, i.invMake, i.invModel, i.classificationId
            FROM reviews r
            JOIN clients c ON r.clientId = c.clientId
            JOIN inventory i ON r.invId = i.invId
            WHERE r.clientId = :clientId
            ORDER BY r.reviewId DESC';
    
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}

//get review based on loggedin user
function oneReviewview($reviewId)
{    
    //$clientId = $_SESSION['clientData']['clientId'];
    $db = phpmotorsConnect();
    $sql = 'SELECT r.*, c.clientId, c.clientFirstname, c.clientLastname, i.invId, i.invMake, i.invModel, i.classificationId
            FROM reviews r
            JOIN clients c ON r.clientId = c.clientId
            JOIN inventory i ON r.invId = i.invId
            WHERE r.reviewId = :reviewid';
    
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewid', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}

function updatereview($text, $rId)
{
  $db = phpmotorsConnect(); 
  $sql = 'UPDATE reviews SET reviewText = :clienttxt WHERE reviewId = :clientId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clienttxt', $text, PDO::PARAM_STR);
  $stmt->bindValue(':clientId', $rId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

 // Check for an existing review
 function checkExistingReview($rtxt) {
    $db =  phpmotorsConnect();
    $sql = 'SELECT reviewText FROM reviews WHERE reviewText = :txt';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':txt', $rtxt, PDO::PARAM_STR);
    $stmt->execute();
    $matchReview = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    return $matchReview;
    }

 // Delete Review
 function deleteReview($rId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :rvid';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':rvid', $rId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
   }
?>