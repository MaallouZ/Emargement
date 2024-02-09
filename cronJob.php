<?php
include('param.php');

try {
    $conn = new  PDO("mysql:host=$host;dbname=$db", $user, $pwd);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE activite AS a SET a.enabled = 0 WHERE a.dateFinActivite <= CURRENT_DATE;";
    $stmt = $conn -> prepare($sql);

    if ($stmt->execute()) {
        echo "Mise à jour des status des activitées réussie.";
    } else {
        echo "Erreur lors de la mise à jour : " . $stmt->errorInfo()[2];
    }
} catch (PDOException $ex) {
    die( 'Erreur de connexion à la base de données: '.$ex->getMessage());
}
?>