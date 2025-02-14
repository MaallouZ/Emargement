<?php
require_once 'src/model/Repository.php';

class VisitorRepository extends Repository
{

    public function getAllVisitsOnDay(): ?int
    {
        $sql = "SELECT COUNT(*) FROM visiteur WHERE valid = 1;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $visitors = $stmt->fetch()[0];
        return $visitors;
    }

    public function getMaleVisitsOnDay(): ?int
    {
        $sql = "SELECT COUNT(*) FROM visiteur WHERE valid = 1 AND sexe = 'M';";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $male = $stmt->fetch()[0];
        return $male;
    }

    public function getFemaleVisitsOnDay(): ?int
    {
        $sql = "SELECT COUNT(*) FROM visiteur WHERE valid = 1 AND sexe = 'F';";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $female = $stmt->fetch()[0];
        return $female;
    }
    public function getAllVisitsOnDayByActivity(int $act, string $date): ?int
    {
        $sql = "SELECT COUNT(*)
            FROM estPresent AS eP
            INNER JOIN visiteur AS v ON eP.IDvisiteur = v.IDvisiteur 
            WHERE eP.present = 1
            AND eP.idActivite = :act
            AND eP.date = :date;";
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindValue(':act', $act, PDO::PARAM_INT);
        $stmt -> bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->execute();

        $visitors = $stmt->fetch()[0];
        return $visitors;
    }

    public function getMaleVisitsOnDayByActivity(int $act, string $date): ?int
    {
        $sql = "SELECT COUNT(*)
            FROM estPresent AS eP
            INNER JOIN visiteur AS v ON eP.IDvisiteur = v.IDvisiteur 
            WHERE eP.present = 1
            AND eP.idActivite = :act
            AND eP.date = :date
            AND v.sexe = 'M';";
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindValue(':act', $act, PDO::PARAM_INT);
        $stmt -> bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->execute();

        $male = $stmt->fetch()[0];
        return $male;
    }

    public function getFemaleVisitsOnDayByActivity(int $act, string $date): ?int
    {
        $sql = "SELECT COUNT(*)
            FROM estPresent AS eP
            INNER JOIN visiteur AS v ON eP.IDvisiteur = v.IDvisiteur 
            WHERE eP.present = 1
            AND eP.idActivite = :act
            AND eP.date = :date
            AND v.sexe = 'F';";
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindValue(':act', $act, PDO::PARAM_INT);
        $stmt -> bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->execute();

        $female = $stmt->fetch()[0];
        return $female;
    }

    public function getVisitors()
    {
        $sql = "SELECT IDVisiteur, nom, prenom, TIMESTAMPDIFF(YEAR, DDN, CURDATE()) AS age, sexe, ADH, ville, tel, valid, DDN FROM visiteur ORDER BY nom;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function getVisitorsByActivity(int $activityID, string $date): PDOStatement
    {
        if ($date === date('Y-m-d')) {
            $sql = "SELECT idPresence, nom, prenom, TIMESTAMPDIFF(YEAR, DDN, CURDATE()) AS age, sexe, ADH, ville, tel, present, DDN, visiteur.IDvisiteur FROM visiteur INNER JOIN estPresent ON estPresent.IDvisiteur = visiteur.IDvisiteur WHERE estPresent.date = CURRENT_DATE AND estPresent.idActivite = :act AND visiteur.valid = 1  ORDER BY nom;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':act', $activityID, PDO::PARAM_INT);
        } else {
            $sql = "SELECT idPresence, nom, prenom, TIMESTAMPDIFF(YEAR, DDN, CURDATE()) AS age, sexe, ADH, ville, tel, present, DDN, visiteur.IDvisiteur FROM visiteur INNER JOIN estPresent ON estPresent.IDvisiteur = visiteur.IDvisiteur WHERE estPresent.date = :date AND estPresent.idActivite = :act ORDER BY nom;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':act', $activityID, PDO::PARAM_INT);
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        }
        return $stmt;
    }

    public function printTabVisitors(PDOStatement $stmt): string
    {
        $stmt->execute();
        $ndata = $stmt->rowCount();
        $data = $stmt->fetchAll();

        ob_start();
        for ($i = 0; $i < $ndata; $i++) {
            echo "<tr>";
            if ($data[$i][8] == 0) {
                echo ('<td><a href="index.php?action=setValid&id=' . $data[$i][0] . '" class="btn btn-danger btn-icon-split">
                <span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text">Absent</span></a><a href="#" class="btn btn-secondary btn-circle ms-3" onclick="openModal(\'' . json_encode($i) . '\')">
                <i class="fas fa-pencil-alt"></i>
                    <a/></td>');
            } else {
                echo ('<td><a href="index.php?action=setUnvalid&id=' . $data[$i][0] . '" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Present</span></a><a href="#" class="btn btn-secondary btn-circle ms-3" onclick="openModal(\'' . json_encode($i) . '\')">
                    <i class="fas fa-pencil-alt"></i>
                    <a/></td>');
            }
            for ($j = 1; $j < 8; $j++) {
                echo ("<td>" . $data[$i][$j] . "</td>");
            }
            echo "</tr>";
        }
        return ob_get_clean();
    }

    public function printTabVisitorsActivity(int $activityID, PDOStatement $stmt): string
    {
        $stmt->execute();
        $ndata = $stmt->rowCount();
        $data = $stmt->fetchAll();

        ob_start();
        for ($i = 0; $i < $ndata; $i++) {
            echo "<tr>";
            if ($data[$i][8] == 0) {
                echo ('<td><a href="index.php?action=setPresent&act=' . $activityID . '&id=' . $data[$i][0] . '&date='.$_GET['date'].'" class="btn btn-danger btn-icon-split">
                <span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text">Absent</span></a></td>');
            } else {
                echo ('<td><a href="index.php?action=setAbsent&act=' . $activityID . '&id=' . $data[$i][0] . '&date='.$_GET['date'].'" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Present</span></a></td>');
            }
            for ($j = 1; $j < 8; $j++) {
                echo ("<td>" . $data[$i][$j] . "</td>");
            }
            echo "</tr>";
        }
        return ob_get_clean();
    }

    public function setPresent(int $visitorID): void
    {
        $sql = "UPDATE `estPresent` SET present = '1' WHERE estPresent.idPresence = :id ;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $visitorID, PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function setAbsent(int $visitorID): void
    {
        $sql = "UPDATE `estPresent` SET present = '0' WHERE estPresent.idPresence = :id ;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $visitorID, PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function setValid(int $idVisitor): void{
        $sql = "UPDATE visiteur SET valid = 1 WHERE IDVisiteur = :idVisitor;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindValue(":idVisitor", $idVisitor, PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function setUnvalid(int $idVisitor): void{
        $sql = "UPDATE visiteur SET valid = 0 WHERE IDVisiteur = :idVisitor;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindValue(":idVisitor", $idVisitor, PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function newVisitor(string $sexe, string $nom, string $prenom, string $DDN, string $ville, string $tel, bool $ADH)
    {
        try {
            $sql = "INSERT INTO `visiteur` (`IDvisiteur`, `nom`, `prenom`, `DDN`, `ville`, `ADH`, `tel`, `sexe`) VALUES (NULL, :nom , :prenom , :DDN , :ville , :ADH , :tel , :sexe );";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":sexe", $sexe, PDO::PARAM_STR);
            $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
            $stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
            $stmt->bindValue(":DDN", $DDN, PDO::PARAM_STR);
            $stmt->bindValue(":ville", $ville, PDO::PARAM_STR);
            $stmt->bindValue(":tel", $tel, PDO::PARAM_STR);
            $stmt->bindParam(":ADH", $ADH, PDO::PARAM_BOOL);

            $stmt->execute();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function editVisitor(string $sexe, string $nom, string $prenom, string $DDN, string $ville, string $tel, bool $ADH, int $idVisitor)
    {
        try {
            $sql = "UPDATE `visiteur` SET `nom` = :nom , `prenom` = :prenom , `DDN` = :DDN , `ville` = :ville , `ADH` = :ADH , `tel` = :tel , `sexe` = :sexe WHERE IDvisiteur = :idVisitor;";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":sexe", $sexe, PDO::PARAM_STR);
            $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
            $stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
            $stmt->bindValue(":DDN", $DDN, PDO::PARAM_STR);
            $stmt->bindValue(":ville", $ville, PDO::PARAM_STR);
            $stmt->bindValue(":tel", $tel, PDO::PARAM_STR);
            $stmt->bindParam(":ADH", $ADH, PDO::PARAM_BOOL);
            $stmt->bindParam("idVisitor", $idVisitor, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function countVisitorsOnPeriod(int $idActivity): int
    {
        $sqlTotalVisiteur = 'SELECT COUNT(*) 
        FROM estPresent  
        WHERE idActivite = :idActivite
        AND present = 1 
        AND estPresent.date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH) AND CURRENT_DATE;';

        $stmt = $this->conn->prepare($sqlTotalVisiteur);
        $stmt->bindParam(":idActivite", $idActivity, PDO::PARAM_INT);
        $stmt->execute();

        $totalVisiteur = $stmt->fetch();
        return $totalVisiteur[0];
    }

    public function countMen(int $idActivity): int
    {
        $sqlHF = "SELECT visiteur.sexe, COUNT(DISTINCT estPresent.IDvisiteur)
        FROM estPresent
        INNER JOIN visiteur ON estPresent.IDvisiteur = visiteur.IDvisiteur
        WHERE idActivite = :idActivite
        AND present = 1
        AND estPresent.date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH) AND CURRENT_DATE
        AND visiteur.sexe = 'M';";

        $stmt = $this->conn->prepare($sqlHF);
        $stmt->bindParam(":idActivite", $idActivity, PDO::PARAM_INT);
        $stmt->execute();

        $total_M = $stmt->fetch();
        return $total_M[1];
    }

    public function countWomen(int $idActivity): int
    {
        $sqlHF = "SELECT visiteur.sexe, COUNT(DISTINCT estPresent.IDvisiteur)
        FROM estPresent
        INNER JOIN visiteur ON estPresent.IDvisiteur = visiteur.IDvisiteur
        WHERE idActivite = :idActivite
        AND present = 1
        AND estPresent.date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH) AND CURRENT_DATE
        AND visiteur.sexe = 'F';";

        $stmt = $this->conn->prepare($sqlHF);
        $stmt->bindParam(":idActivite", $idActivity, PDO::PARAM_INT);
        $stmt->execute();

        $total_W = $stmt->fetch();
        return $total_W[1];
    }
}
