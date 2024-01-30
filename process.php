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

    header('Location: http://anim.mjcbolbec.fr/visiteurs.php?act='.$_GET['act']); 
}

if ($method == 'absence') {
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
    $age = htmlspecialchars($_POST["age_visiteur"]);
    $ville = htmlspecialchars($_POST["ville_visiteur"]);
    $tel = htmlspecialchars($_POST["tel_visiteur"]);
    $ADH = $_POST["ADH_visiteur"];

    $sql = "INSERT INTO `visiteur` (`IDvisiteur`, `nom`, `prenom`, `age`, `ville`, `ADH`, `tel`, `sexe`) VALUES (NULL, :nom , :prenom , :age , :ville , :ADH , :tel , :sexe );";
    $stmt = $conn -> prepare($sql);
    $stmt->bindParam(":sexe",$sexe, PDO::PARAM_STR);
    $stmt->bindParam(":nom",$nom, PDO::PARAM_STR);
    $stmt->bindParam(":prenom",$prenom, PDO::PARAM_STR);
    $stmt->bindValue(":age",$age, PDO::PARAM_INT);
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
?>