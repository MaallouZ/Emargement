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

function printActivite($conn) {

    $activite = getActivite($conn);
    $nbActivite = getNbActivite($conn);


    for ($i=0; $i < $nbActivite; $i++) { 

        $jsActivite = str_replace(' ', '-', $activite[$i][1]);
            
        echo ('<!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse'.$jsActivite.'"
                aria-expanded="true" aria-controls="collapse'.$jsActivite.'">
                <i class="fas fa-fw fa-table"></i>
                <span>'.$activite[$i][1].'</span>
            </a>
            <div id="collapse'.$jsActivite.'" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="visiteurs.php?act='.$activite[$i][0].'">Visiteurs</a>'.
                    // <a class="collapse-item" href="historique.php?act='.$activite[$i][0].'">Historique</a>
                    // <a class="collapse-item" href="stat.php?act='.$activite[$i][0].'">Statistiques</a>
                '</div>
            </div>
        </li>
        ');
    }
}
?>