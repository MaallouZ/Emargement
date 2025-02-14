<?php
require('db.php');
include('param.php');

if ($_GET['method'] == "retour") {
    $idEmprunt = htmlspecialchars($_GET['emprunt']);
    $dateRetour = date("Y-m-d");
    $sql = 'UPDATE emprunte INNER JOIN materiel ON emprunte.idMateriel = materiel.idMateriel SET emprunte.dateRetour = :dateRetour , materiel.estPrete = 0, rendu = 1 WHERE idEmprunt = :idEmprunt ;';
    $stmt = $conn -> prepare($sql);
    $stmt -> bindParam(":dateRetour", $dateRetour, PDO::PARAM_STR);
    $stmt -> bindParam(":idEmprunt", $idEmprunt, PDO::PARAM_INT);
    $stmt -> execute();

    $_GET['method'] = null;
    header('Location: https://anim.mjcbolbec.fr/emprunt.php');
}


if ($_POST['method'] == 'newLocation') {
    

    $id = htmlspecialchars($_POST['idVisLoc']);
    $ref = htmlspecialchars($_POST['idMat']);
    $dateRetour = htmlspecialchars($_POST['dateRetour']);
    $etatMat = htmlspecialchars(json_encode($_POST['etatMat']));

    //Date

    $sql = "INSERT INTO emprunte (dateEmprunt,dateRetourEstime,idVisiteur,idMateriel) 
    VALUES (DATE(NOW()),DATE( :dateRetour ), :id , :idMat);";

    $req = $conn -> prepare($sql);
    $req -> bindValue( ":idMat" , $ref, PDO :: PARAM_INT);
    $req -> bindValue( ":id" , $id, PDO :: PARAM_INT);
    $req -> bindParam(":dateRetour", $dateRetour, PDO::PARAM_STR);
    $req -> execute() or die(print_r($req -> errorInfo()));

    $sql = "UPDATE materiel SET etatMateriel = :etatMat , estPrete = 1 WHERE materiel.idMateriel = :idMat;";
    $req2 = $conn->prepare($sql);
    $req2 -> bindValue( ":etatMat" , $etatMat , PDO :: PARAM_STR);
    $req2 -> bindValue( ":idMat" , $ref, PDO :: PARAM_INT);
    $req2 -> execute() or die(print_r($req2 -> errorInfo()));

    $_POST['method'] = NULL;
    header('Location: https://anim.mjcbolbec.fr/emprunt.php');
}

if ($_POST['method'] == "prolongEmprunt") {
    $idEmprunt = htmlspecialchars($_POST['idEmprunt']);
    $date = htmlspecialchars($_POST['dateProlong']);

    $sql = "UPDATE emprunte SET dateRetourEstime = :dateRetourEstime WHERE idEmprunt = :idEmprunt;";

    $stmt = $conn -> prepare($sql);
    $stmt -> bindParam(":dateRetourEstime", $date, PDO::PARAM_STR);
    $stmt -> bindParam(":idEmprunt", $idEmprunt, PDO::PARAM_INT);
    $stmt -> execute();

    $_POST['method'] = null;
    header('Location: https://anim.mjcbolbec.fr/emprunt.php');
}

if ($_GET['method'] == "preter") {
    $idEmprunt = htmlspecialchars($_GET['emprunt']);
    $sql = 'UPDATE emprunte INNER JOIN materiel ON emprunte.idMateriel = materiel.idMateriel SET emprunte.dateRetour = NULL , materiel.estPrete = 1 , rendu = WHERE idEmprunt = :idEmprunt ;';
    $stmt = $conn -> prepare($sql);
    $stmt -> bindParam("idEmprunt", $idEmprunt, PDO::PARAM_INT);
    $stmt -> execute();

    $_GET['method'] = null;
    header('Location: https://anim.mjcbolbec.fr/emprunt.php');
}

?>