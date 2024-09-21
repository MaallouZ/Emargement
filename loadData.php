<?php
require('db.php');

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $idActivite = htmlspecialchars($_POST["idActivite"]);
        $dateDebut =  htmlspecialchars($_POST["dateDebut"]);
        $dateFin = htmlspecialchars($_POST["dateFin"]);

        // Total des visiteurs sur la période
        $sqlTotalVisiteur = 'SELECT COUNT(*) 
            FROM estPresent 
            INNER JOIN journée ON estPresent.idJournee = journée.idJournee 
            WHERE idActivite = :idActivite
            AND present = 1 
            AND journée.dateJournee BETWEEN  :dateDebut AND :dateFin;';

        $stmt = $conn->prepare($sqlTotalVisiteur);
        $stmt ->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
        $stmt ->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
        $stmt ->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
        $stmt->execute();

        $totalVisiteur = $stmt->fetch();

        // Total d'hommes et de femmes
        $sqlHF = "SELECT visiteur.sexe, COUNT(DISTINCT estPresent.IDvisiteur)
            FROM estPresent
            INNER JOIN visiteur ON estPresent.IDvisiteur = visiteur.IDvisiteur
            INNER JOIN journée ON estPresent.idJournee = journée.idJournee
            WHERE idActivite = :idActivite
            AND present = 1
            AND journée.dateJournee BETWEEN :dateDebut AND :dateFin
            GROUP BY visiteur.sexe;";

        $stmt2 = $conn->prepare($sqlHF);
        $stmt2->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
        $stmt2->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
        $stmt2->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
        $stmt2->execute();

        $total_HF = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        //Fréquentation sur la période
        $sqlFrequentation = "SELECT journée.dateJournee, COUNT(*)
            FROM estPresent
            INNER JOIN journée ON estPresent.idJournee = journée.idJournee
            WHERE idActivite = :idActivite
            AND present = 1
            AND journée.dateJournee BETWEEN :dateDebut AND :dateFin
            GROUP BY journée.dateJournee;";

        $stmt3 = $conn->prepare($sqlFrequentation);
        $stmt3->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
        $stmt3->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
        $stmt3->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
        $stmt3->execute();

        $frequentation = $stmt3->fetchAll();

        //Moyenne visiteur/jour
        $sqlMoyenne = "SELECT AVG(nb_present) AS moyenne_presences FROM (
                            SELECT COUNT(*) AS nb_present
                            FROM estPresent
                            INNER JOIN journée ON estPresent.idJournee = journée.idJournee
                            WHERE estPresent.idActivite = :idActivite
                            AND estPresent.present = 1
                            AND journée.dateJournee BETWEEN :dateDebut AND :dateFin
                            GROUP BY journée.dateJournee
                        ) AS t;";

        $stmt4 = $conn -> prepare($sqlMoyenne);
        $stmt4->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
        $stmt4->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
        $stmt4->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
        $stmt4->execute();

        $moyenne = $stmt4-> fetch();

        $response = [
            "status" => "success",
            "totalVisiteur" => $totalVisiteur[0],
            "total_H" => $total_HF[1]["COUNT(DISTINCT estPresent.IDvisiteur)"],
            "total_F" => $total_HF[0]["COUNT(DISTINCT estPresent.IDvisiteur)"],
            "frequentation" => $frequentation,
            "moyenne" => floatval($moyenne[0])
        ];

        echo json_encode($response);

    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Erreur lors de la connexion à la base de données: " . $e->getMessage()
        ]);
    }
}
else{
    echo json_encode([
        "status" => "error",
        "message" => "Requête non autorisée. Utilisez la méthode POST."
    ]);
    exit();
}
?>