<?php
require('db.php');

if ($_GET['method'] == 'presence') {
    $sql = "UPDATE `estPresent` SET present = '1' WHERE estPresent.idPresence = :id ;";
    $stmt = $conn -> prepare($sql);
    $stmt->bindValue(":id",$_GET["id"], PDO::PARAM_INT);
    
    try {
        $stmt -> execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    $_GET['method'] = NULL;
    header('Location: http://anim.mjcbolbec.fr/visiteurs.php?act='.$_GET['act']); 
}

if ($_GET['method'] == 'absence') {
    $sql = "UPDATE `estPresent` SET present = '0' WHERE estPresent.idPresence = :id ;";
    $stmt = $conn -> prepare($sql);
    $stmt->bindValue(":id",$_GET["id"], PDO::PARAM_INT);
    try {
        $stmt -> execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    $_GET['method'] = NULL;
    header('Location: http://anim.mjcbolbec.fr/visiteurs.php?act='.$_GET['act']); 
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
    $stmt = $conn -> prepare($sql);
    $stmt->bindParam(":sexe",$sexe, PDO::PARAM_STR);
    $stmt->bindParam(":nom",$nom, PDO::PARAM_STR);
    $stmt->bindParam(":prenom",$prenom, PDO::PARAM_STR);
    $stmt->bindValue(":DDN",$DDN, PDO::PARAM_STR);
    $stmt->bindValue(":ville",$ville, PDO::PARAM_STR);
    $stmt->bindValue(":tel",$tel, PDO::PARAM_STR);
    $stmt->bindParam(":ADH", $ADH, PDO::PARAM_BOOL);

    try {
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    $_POST["method"] = NULL;
    header('Location: http://anim.mjcbolbec.fr/index.php');
}

if ($_POST['method'] == "addActivite") {
    
    $libelle = htmlspecialchars($_POST['libelleAct']);
    $dateDebut = htmlspecialchars($_POST["dateDebut"]);
    $dateFin = htmlspecialchars($_POST["dateFin"]);

    $sql = "INSERT INTO `activite` (idActivite, libelleActivite, dateDebutActivite, dateFinActivite) VALUES (NULL, :libelle , :debut , :fin );";
    $stmt = $conn -> prepare($sql);
    $stmt->bindValue(":libelle", $libelle, PDO::PARAM_STR);
    $stmt->bindValue(":debut", $dateDebut, PDO::PARAM_STR);
    $stmt->bindValue(":fin", $dateFin, PDO::PARAM_STR);

    try {
        $stmt -> execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    $_POST['method'] = NULL;
    header('Location: http://anim.mjcbolbec.fr/index.php');
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

    $stmt = $conn -> prepare($sql);
    $stmt->bindParam(":sexe",$sexe, PDO::PARAM_STR);
    $stmt->bindParam(":nom",$nom, PDO::PARAM_STR);
    $stmt->bindParam(":prenom",$prenom, PDO::PARAM_STR);
    $stmt->bindValue(":DDN",$DDN, PDO::PARAM_INT);
    $stmt->bindValue(":ville",$ville, PDO::PARAM_STR);
    $stmt->bindValue(":tel",$tel, PDO::PARAM_STR);
    $stmt->bindParam(":ADH", $ADH, PDO::PARAM_BOOL);
    $stmt->bindParam("idVisitor", $idVisitor, PDO::PARAM_INT);

    try {
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex-> getMessage();
    }

    $_POST['method'] = NULL;
    header('Location: http://anim.mjcbolbec.fr/visiteurs.php?act='.$_POST['idAct']);
}
?>