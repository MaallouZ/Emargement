<?php
require("db.php");

function addDay($conn){

    $sql = "SELECT dateJournee FROM journée ORDER BY dateJournee DESC LIMIT 1;";
    $stmt = $conn -> prepare($sql);
    $stmt->execute();
    $lastday = $stmt -> fetch()[0];
    $today = date('Y-m-d');

    if($today != $lastday){
        // On ajoute une journée dans la base de données
        $sql = "INSERT INTO journée (dateJournee) VALUES (". $today .");";
        $stmt= $conn -> prepare($sql);
        $stmt->execute();
    }
}
?>