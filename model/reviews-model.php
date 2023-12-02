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

function oneReview()
{    
    //function is from account-model
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


?>