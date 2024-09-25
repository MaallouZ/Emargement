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
        $stmt->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
        $stmt->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
        $stmt->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
        $stmt->execute();

        $totalVisiteur = $stmt->fetch();

        // Total d'hommes
        $sqlHF = "SELECT visiteur.sexe, COUNT(DISTINCT estPresent.IDvisiteur)
            FROM estPresent
            INNER JOIN visiteur ON estPresent.IDvisiteur = visiteur.IDvisiteur
            INNER JOIN journée ON estPresent.idJournee = journée.idJournee
            WHERE idActivite = :idActivite
            AND present = 1
            AND journée.dateJournee BETWEEN :dateDebut AND :dateFin
            AND visiteur.sexe = 'M';";

        $stmt = $conn->prepare($sqlHF);
        $stmt->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
        $stmt->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
        $stmt->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
        $stmt->execute();

        $total_H = $stmt->fetch();

        // Total de femmes
        $sqlHF = "SELECT visiteur.sexe, COUNT(DISTINCT estPresent.IDvisiteur)
                FROM estPresent
                INNER JOIN visiteur ON estPresent.IDvisiteur = visiteur.IDvisiteur
                INNER JOIN journée ON estPresent.idJournee = journée.idJournee
                WHERE idActivite = :idActivite
                AND present = 1
                AND journée.dateJournee BETWEEN :dateDebut AND :dateFin
                AND visiteur.sexe = 'F';";

        $stmt = $conn->prepare($sqlHF);
        $stmt->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
        $stmt->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
        $stmt->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
        $stmt->execute();

        $total_F = $stmt->fetch();

        //Fréquentation sur la période
        $sqlFrequentation = "SELECT journée.dateJournee, COUNT(*)
            FROM estPresent
            INNER JOIN journée ON estPresent.idJournee = journée.idJournee
            WHERE idActivite = :idActivite
            AND present = 1
            AND journée.dateJournee BETWEEN :dateDebut AND :dateFin
            GROUP BY journée.dateJournee;";

        $stmt = $conn->prepare($sqlFrequentation);
        $stmt->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
        $stmt->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
        $stmt->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
        $stmt->execute();

        $frequentation = $stmt->fetchAll();

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

        $stmt = $conn->prepare($sqlMoyenne);
        $stmt->bindParam(":idActivite", $idActivite, PDO::PARAM_INT);
        $stmt->bindParam(":dateDebut", $dateDebut, PDO::PARAM_STR);
        $stmt->bindParam(":dateFin", $dateFin, PDO::PARAM_STR);
        $stmt->execute();

        $moyenne = $stmt->fetch();

        $response = [
            "status" => "success",
            "totalVisiteur" => $totalVisiteur[0],
            "total_H" => $total_H[1],
            "total_F" => $total_F[1],
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
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Requête non autorisée. Utilisez la méthode POST."
    ]);
    exit();
}
