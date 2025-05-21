<?php
require_once 'src/model/Repository.php';

class ActivityRepository extends Repository
{

    public function getActivityByAccess(int $idUser): array
    {
        $stmt = $this->conn->prepare("SELECT act.id, act.libelle
            FROM access as acc
            INNER JOIN activite AS act ON acc.idActivite = act.id
            INNER JOIN `user` AS u ON acc.idUser = u.id
            WHERE u.id = :idUser
            AND act.dateDebut <= CURRENT_DATE()
            AND act.dateFin >= CURRENT_DATE();");
        $stmt->bindValue(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->execute();
        $activite = $stmt->fetchAll();
        return $activite;
    }

    public function getNbActivity(int $idUser): int
    {
        $stmt = $this->conn->prepare("SELECT act.id, act.libelle
            FROM access as acc
            INNER JOIN activite AS act ON acc.idActivite = act.id
            INNER JOIN `user` AS u ON acc.idUser = u.id
            WHERE u.id = :idUser
            AND act.dateDebut <= CURRENT_DATE()
            AND act.dateFin >= CURRENT_DATE();");
        $stmt->bindValue(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->execute();
        $nbActivite = $stmt->rowCount();
        return $nbActivite;
    }

    public function updateActivityStatus(): void
    {
        try {
            $sql = "UPDATE activite AS a SET a.enabled = 0 WHERE a.dateFin <= CURRENT_DATE;";
            $stmt = $this->conn->prepare($sql);

            if ($stmt->execute()) {
                echo "Mise à jour des status des activitées réussie.";
            } else {
                echo "Erreur lors de la mise à jour : " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $ex) {
            die('Erreur de connexion à la base de données: ' . $ex->getMessage());
        }
    }

    public function newActivity(string $libelle, string $dateDebut, string $dateFin): void
    {
        try {
            $sql = "INSERT INTO `activite` (id, libelle, dateDebut, dateFin) VALUES (NULL, :libelle , :debut , :fin );";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":libelle", $libelle, PDO::PARAM_STR);
            $stmt->bindValue(":debut", $dateDebut, PDO::PARAM_STR);
            $stmt->bindValue(":fin", $dateFin, PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getAttendance(int $idActivity, string $debutDate, string $endDate): array
    {
        $sqlAttendance = "SELECT DATE_FORMAT(estPresent.date, '%d %b') AS 'Date', COUNT(*) AS 'nbVisitors', SUM(visiteur.sexe = 'M') AS 'nbHomme', SUM(visiteur.sexe = 'F') AS 'nbFemme', SUM(visiteur.ADH = 1) AS 'nbAdh'
        FROM estPresent
        INNER JOIN visiteur ON estPresent.idVisiteur = visiteur.id
        WHERE idActivite = :idActivite
        AND present = 1
        AND estPresent.date BETWEEN :debutDate AND :endDate
        GROUP BY estPresent.date;";

        $stmt = $this->conn->prepare($sqlAttendance);
        $stmt->bindParam(":idActivite", $idActivity, PDO::PARAM_INT);
        $stmt->bindParam(":debutDate", $debutDate, PDO::PARAM_STR);
        $stmt->bindParam(":endDate", $endDate, PDO::PARAM_STR);
        $stmt->execute();

        $attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $attendance;
    }

    public function getAverageVisits(int $idActivity, string $debutDate, string $endDate): float
    {
        $sqlMoyenne = "SELECT AVG(nb_present) AS moyenne_presences FROM (
            SELECT COUNT(*) AS nb_present
            FROM estPresent
            WHERE estPresent.idActivite = :idActivite
            AND estPresent.present = 1
            AND estPresent.date BETWEEN :debutDate AND :endDate
            GROUP BY estPresent.date
        ) AS t;";

        $stmt = $this->conn->prepare($sqlMoyenne);
        $stmt->bindParam(":idActivite", $idActivity, PDO::PARAM_INT);
        $stmt->bindParam(":debutDate", $debutDate, PDO::PARAM_STR);
        $stmt->bindParam(":endDate", $endDate, PDO::PARAM_STR);
        $stmt->execute();

        $avg = $stmt->fetch()[0];

        if (isset($avg)) {
            return $avg;
        } else {
            return 0;
        }
    }

    public function getExcelData(int $act, string $date)
    {
        $sql = "SELECT nom, prenom, TIMESTAMPDIFF(YEAR, DDN, CURDATE()) AS age, sexe, ADH, ville
            FROM visiteur 
            INNER JOIN estPresent ON estPresent.idVisiteur = visiteur.id 
            WHERE estPresent.date = :date 
            AND estPresent.idActivite = :act
            AND estPresent.present = 1
            ORDER BY nom;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':act', $act, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getActivityName(int $act)
    {
        $sql = "SELECT libelle
        FROM activite
        WHERE id = :act;";

        $stmt = $this->conn->prepare($sql);
        $stmt -> bindParam(':act', $act, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetch();

        return $result[0];
    }
}
