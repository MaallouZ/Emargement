<?php
require('db.php');
include('param.php');
include('logger.php');

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

if ($_POST['method'] == "addVisitor") {
    $sexe = $_POST["sexe_visiteur"];
    $nom = htmlspecialchars($_POST["nom_visiteur"]);
    $prenom = htmlspecialchars($_POST["prenom_visiteur"]);
    $DDN = htmlspecialchars($_POST["DDN_visiteur"]);
    $ville = htmlspecialchars($_POST["ville_visiteur"]);
    $tel = htmlspecialchars($_POST["tel_visiteur"]);
    $ADH = $_POST["ADH_visiteur"];

    $sql = "INSERT INTO `visiteur` (`IDvisiteur`, `nom`, `prenom`, `DDN`, `ville`, `ADH`, `tel`, `sexe`) VALUES (NULL, :nom , :prenom , :DDN , :ville , :ADH , :tel , :sexe );";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":sexe", $sexe, PDO::PARAM_STR);
    $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
    $stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
    $stmt->bindValue(":DDN", $DDN, PDO::PARAM_STR);
    $stmt->bindValue(":ville", $ville, PDO::PARAM_STR);
    $stmt->bindValue(":tel", $tel, PDO::PARAM_STR);
    $stmt->bindParam(":ADH", $ADH, PDO::PARAM_BOOL);

    try {
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    $_POST["method"] = NULL;
    header('Location: https://anim.mjcbolbec.fr/index.php');
}

if ($_POST['method'] == "addActivite") {

    $libelle = htmlspecialchars($_POST['libelleAct']);
    $dateDebut = htmlspecialchars($_POST["dateDebut"]);
    $dateFin = htmlspecialchars($_POST["dateFin"]);

    $sql = "INSERT INTO `activite` (idActivite, libelleActivite, dateDebutActivite, dateFinActivite) VALUES (NULL, :libelle , :debut , :fin );";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":libelle", $libelle, PDO::PARAM_STR);
    $stmt->bindValue(":debut", $dateDebut, PDO::PARAM_STR);
    $stmt->bindValue(":fin", $dateFin, PDO::PARAM_STR);

    try {
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    $_POST['method'] = NULL;
    header('Location: https://anim.mjcbolbec.fr/index.php');
}


if ($_POST['method'] == 'editVisitor') {

    $idVisitor = $_POST['idVisitor'];
    $sexe = $_POST["sexe_visiteur"];
    $nom = htmlspecialchars($_POST["nom_visiteur"]);
    $prenom = htmlspecialchars($_POST["prenom_visiteur"]);
    $DDN = htmlspecialchars($_POST["DDN_visiteur"]);
    $ville = htmlspecialchars($_POST["ville_visiteur"]);
    $tel = htmlspecialchars($_POST["tel_visiteur"]);
    $ADH = $_POST["ADH_visiteur"];

    $sql = "UPDATE `visiteur` SET `nom` = :nom , `prenom` = :prenom , `DDN` = :DDN , `ville` = :ville , `ADH` = :ADH , `tel` = :tel , `sexe` = :sexe WHERE IDvisiteur = :idVisitor;";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":sexe", $sexe, PDO::PARAM_STR);
    $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
    $stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
    $stmt->bindValue(":DDN", $DDN, PDO::PARAM_INT);
    $stmt->bindValue(":ville", $ville, PDO::PARAM_STR);
    $stmt->bindValue(":tel", $tel, PDO::PARAM_STR);
    $stmt->bindParam(":ADH", $ADH, PDO::PARAM_BOOL);
    $stmt->bindParam("idVisitor", $idVisitor, PDO::PARAM_INT);

    try {
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    $_POST['method'] = NULL;
    header('Location: https://anim.mjcbolbec.fr/visiteurs.php?act=' . $_POST['idAct']);
}

if ($_GET['method'] == 'presence') {
    $sql = "UPDATE `estPresent` SET present = '1' WHERE estPresent.idPresence = :id ;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $_GET["id"], PDO::PARAM_INT);

    try {
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    $_GET['method'] = NULL;
    header('Location: https://anim.mjcbolbec.fr/visiteurs.php?act=' . $_GET['act']);
}

if ($_GET['method'] == 'absence') {
    $sql = "UPDATE `estPresent` SET present = '0' WHERE estPresent.idPresence = :id ;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $_GET["id"], PDO::PARAM_INT);
    try {
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    $_GET['method'] = NULL;
    header('Location: https://anim.mjcbolbec.fr/visiteurs.php?act=' . $_GET['act']);
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

