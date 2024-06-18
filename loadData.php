<?php
require('db.php');
include('param.php');

$idActivite = htmlspecialchars($_POST["idActivite"]);
$dateDebut =htmlspecialchars($_POST["dateDebut"]);
$dateFin = htmlspecialchars($_POST["dateFin"]);

// Total des visiteurs sur la période
$sqlTotalVisiteur = 'SELECT COUNT(*) 
FROM estpresent 
INNER JOIN journée ON estpresent.idJournee = journée.idJournee 
WHERE idActivite = :idActivite 
AND present = 1 
AND journée.dateJournee BETWEEN  :dateDebut AND :dateFin;';

$stmt = $conn -> prepare($sqlTotalVisiteur);
$stmt ->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
$stmt ->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
$stmt ->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
$stmt -> execute();

$totalVisiteur = $stmt -> fetchAll();
echo $totalVisiteur[0][0];


// Total d'hommes et de femmes
$sqlHF = "SELECT visiteur.sexe, COUNT(DISTINCT estpresent.IDvisiteur)
FROM estpresent
INNER JOIN visiteur ON estpresent.IDvisiteur = visiteur.IDvisiteur
INNER JOIN journée ON estpresent.idJournee = journée.idJournee
WHERE idActivite = :idActivite
AND present = 1
AND journée.dateJournee BETWEEN :dateDebut AND :dateFin
GROUP BY visiteur.sexe;";

$stmt = $conn -> prepare($sqlHF);
$stmt ->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
$stmt ->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
$stmt ->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
$stmt -> execute();

$total_HF = $stmt -> fetchAll();
$_POST['total_HF'] = $total_HF;

//Fréquentation sur la période
$sqlFrequentation = "SELECT journée.dateJournee, COUNT(*)
FROM estpresent
INNER JOIN journée ON estpresent.idJournee = journée.idJournee
WHERE idActivite = :idActivite
AND present = 1
AND journée.dateJournee BETWEEN :dateDebut AND :dateFin
GROUP BY journée.dateJournee;";

$stmt = $conn -> prepare($sqlFrequentation);
$stmt ->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
$stmt ->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
$stmt ->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
$stmt -> execute();

$frequentation = $stmt -> fetchAll();
$_POST['frequentation'] = $frequentation;
?>