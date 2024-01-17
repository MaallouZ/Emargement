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
        $sql = "INSERT INTO journée (dateJournee) VALUES (NOW());";
        $stmt= $conn -> prepare($sql);
        $stmt->execute();
    }
}

function printEmarg($conn){
    $sql = "SELECT nom, prenom, age, sexe, ADH, ville, tel, present FROM visiteur INNER JOIN estpresent ON estpresent.IDvisiteur = visiteur.IDvisiteur WHERE estpresent.idActivite = 1;";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();

    $ndata = $stmt -> rowCount();
    $data = $stmt -> fetchAll();

    for ($i = 0; $i < $ndata; $i++) {
        echo "<tr>";
        for ($j=0; $j < 8 ; $j++) { 
           echo("<td>" . $data[$i][$j] . "</td>");
        }
        echo "</tr>";
    }
}
?>

