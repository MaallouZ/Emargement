<?php
require('db.php');


$method = $_GET['method'];

if ($method == 'presence') {
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

    header('Location: http://anim.mjcbolbec.fr/visiteurs.php?act='.$_GET['act']); 
}
?>