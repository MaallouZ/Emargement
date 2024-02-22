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

function getActivite($conn){
    global $date;

    $stmt = $conn -> prepare("SELECT idActivite, libelleActivite FROM activite WHERE activite.dateDebutActivite <= :date AND activite.dateFinActivite >= :date;");
    $stmt -> bindValue(':date', $date, PDO::PARAM_STR);
    $stmt -> execute();
    $activite = $stmt -> fetchAll();
    return $activite;
}

function getNbActivite($conn){
    global $date;

    $stmt = $conn -> prepare("SELECT idActivite, libelleActivite FROM activite WHERE activite.dateDebutActivite <= :date AND activite.dateFinActivite >= :date;");
    $stmt -> bindValue(':date', $date, PDO::PARAM_STR);
    $stmt -> execute();
    $nbActivite = $stmt -> rowCount();
    return $nbActivite;
}

function getJournee($conn){
    global $date;
    $stmt = $conn -> prepare("SELECT * FROM journée;");
    $stmt -> execute();
    $tabJournée = $stmt -> fetchAll();

    return $tabJournée;
}

function printEmprunt($conn){

    try {
        $stmt = $conn ->prepare("SELECT idEmprunt, emprunte.idVisiteur, visiteur.nom, visiteur.prenom, emprunte.idMateriel, materiel.libelleMateriel, materiel.referenceMateriel, dateEmprunt, dateRetourEstime, materiel.estPrete, dateRetour FROM emprunte INNER JOIN materiel ON emprunte.idMateriel = materiel.idMateriel INNER JOIN visiteur ON emprunte.idVisiteur = visiteur.IDvisiteur;");
        $stmt -> execute();
        $tabEmprunt = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        foreach ($tabEmprunt as $row) {
            echo "<tr>";
            echo "<td>".$row['nom']. ' '.$row['prenom']."</td>";
            echo "<td>".$row['libelleMateriel']."</td>";
            echo "<td>".$row['referenceMateriel']."</td>";
            echo "<td>".$row['dateEmprunt']."</td>";
            echo "<td>".$row['dateRetourEstime']."</td>";

            if ($row['estPrete'] == 1) {

                if ($row['dateRetourEstime'] > (date('Y-m-d', strtotime('-3 days')))) {
                    echo ('<td><a href="#" class="btn btn-warning btn-circle btn-lg"></a></td>');
                }
                else{
                    echo ('<td><a href="#" class="btn btn-danger btn-circle btn-lg"></a></td>');
                }
            } else {
                echo ('<td><a href="#" class="btn btn-success btn-circle btn-lg"></a></td>');
            }

            echo "<td>".$row['dateRetour']."</td>";
            echo  '</tr>';
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>

