<?php
require("db.php");

setlocale(LC_TIME, 'fr_FR.UTF8');
$date = date('Y-m-d');

function addDay($conn){

    $sql = "SELECT dateJournee FROM journée ORDER BY dateJournee DESC LIMIT 1;";
    $stmt = $conn -> prepare($sql);
    $stmt->execute();
    $lastday = $stmt -> fetch()[0];
    $today = date('Y-m-d');
    
    if($today != $lastday){
        // On ajoute une journée dans la base de données
        $sql = "INSERT INTO journée (dateJournee) VALUES (DATE(NOW()));";
        $stmt= $conn -> prepare($sql);
        $stmt->execute();
    }
}

addDay($conn);

function getVisiteur($conn){
    $stmt = $conn -> prepare("SELECT * FROM visiteur;");
    $stmt -> execute();
    $tabVisiteur = $stmt -> fetchAll();

    return $tabVisiteur;
}

function getJournee($conn){
    global $date;
    $stmt = $conn -> prepare("SELECT * FROM journée;");
    $stmt -> execute();
    $tabJournée = $stmt -> fetchAll();

    return $tabJournée;
}