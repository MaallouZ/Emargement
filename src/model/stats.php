<?php
require_once 'src/model/Repository.php';

class StatsRespository extends Repository
{

    public function getAttendanceWednesday(string $y1Debut, string $y1End, string $y2Debut, string $y2End)
    {
        $sql = "SELECT
            m.mois_nom,
            COALESCE(y1.nb_visiteurs, 0) AS visiteursY1,
            COALESCE(y2.nb_visiteurs, 0) AS visiteursY2
            FROM
            (
                SELECT 'septembre' AS mois_nom, 9 AS mois_num UNION ALL
                SELECT 'octobre', 10 UNION ALL
                SELECT 'novembre', 11 UNION ALL
                SELECT 'décembre', 12 UNION ALL
                SELECT 'janvier', 1 UNION ALL
                SELECT 'février', 2 UNION ALL
                SELECT 'mars', 3 UNION ALL
                SELECT 'avril', 4 UNION ALL
                SELECT 'mai', 5 UNION ALL
                SELECT 'juin', 6 UNION ALL
                SELECT 'juillet', 7 UNION ALL
                SELECT 'août', 8
            ) AS m
            LEFT JOIN (
            SELECT
                MONTH(date) AS mois,
                COUNT(DISTINCT idVisiteur) AS nb_visiteurs
            FROM estPresent
            WHERE present = 1
                AND DATE_FORMAT(date, '%w') = '3'
                AND date BETWEEN :y1D AND :y1E
            GROUP BY mois
            ) AS y1 ON y1.mois = m.mois_num
            LEFT JOIN (
            SELECT
                MONTH(date) AS mois,
                COUNT(DISTINCT idVisiteur) AS nb_visiteurs
            FROM estPresent
            WHERE present = 1
                AND DATE_FORMAT(date, '%w') = '3'
                AND date BETWEEN :y2D AND :y2E
            GROUP BY mois
            ) AS y2 ON y2.mois = m.mois_num
            ORDER BY FIELD(m.mois_num, 9,10,11,12,1,2,3,4,5,6,7,8);";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':y1D', $y1Debut, PDO::PARAM_STR);
        $stmt->bindParam(':y1E', $y1End, PDO::PARAM_STR);
        $stmt->bindParam(':y2D', $y2Debut, PDO::PARAM_STR);
        $stmt->bindParam(':y2E', $y2End, PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getAttendanceSaturday(string $y1Debut, string $y1End, string $y2Debut, string $y2End)
    {
        $sql = "SELECT
            m.mois_nom,
            COALESCE(y1.nb_visiteurs, 0) AS visiteursY1,
            COALESCE(y2.nb_visiteurs, 0) AS visiteursY2
            FROM
            (
                SELECT 'septembre' AS mois_nom, 9 AS mois_num UNION ALL
                SELECT 'octobre', 10 UNION ALL
                SELECT 'novembre', 11 UNION ALL
                SELECT 'décembre', 12 UNION ALL
                SELECT 'janvier', 1 UNION ALL
                SELECT 'février', 2 UNION ALL
                SELECT 'mars', 3 UNION ALL
                SELECT 'avril', 4 UNION ALL
                SELECT 'mai', 5 UNION ALL
                SELECT 'juin', 6 UNION ALL
                SELECT 'juillet', 7 UNION ALL
                SELECT 'août', 8
            ) AS m
            LEFT JOIN (
            SELECT
                MONTH(date) AS mois,
                COUNT(DISTINCT idVisiteur) AS nb_visiteurs
            FROM estPresent
            WHERE present = 1
                AND DATE_FORMAT(date, '%w') = '6'
                AND date BETWEEN :y1D AND :y1E
            GROUP BY mois
            ) AS y1 ON y1.mois = m.mois_num
            LEFT JOIN (
            SELECT
                MONTH(date) AS mois,
                COUNT(DISTINCT idVisiteur) AS nb_visiteurs
            FROM estPresent
            WHERE present = 1
                AND DATE_FORMAT(date, '%w') = '6'
                AND date BETWEEN :y2D AND :y2E
            GROUP BY mois
            ) AS y2 ON y2.mois = m.mois_num
            ORDER BY FIELD(m.mois_num, 9,10,11,12,1,2,3,4,5,6,7,8);";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':y1D', $y1Debut, PDO::PARAM_STR);
        $stmt->bindParam(':y1E', $y1End, PDO::PARAM_STR);
        $stmt->bindParam(':y2D', $y2Debut, PDO::PARAM_STR);
        $stmt->bindParam(':y2E', $y2End, PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function poleAttendance(string $debut, string $end)
    {
        $sql = "SELECT 
                    a.libelle,
                    ROUND(COUNT(*) * 100.0 / total.total_presences, 2) AS pourcentage_presence
                FROM 
                    estPresent ep
                JOIN 
                    activite a ON ep.idActivite = a.id
                JOIN (
                    SELECT COUNT(*) AS total_presences
                    FROM estPresent
                    WHERE present = 1
                ) AS total
                WHERE 
                    ep.present = 1
                AND
                    ep.date BETWEEN :debut AND :end
                GROUP BY 
                    a.id, a.libelle, total.total_presences
                ORDER BY 
                    pourcentage_presence DESC;
                ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':debut', $debut, PDO::PARAM_STR);
        $stmt->bindParam(':end', $end, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function getCitiesChart()
    {
        $sql = "SELECT 
            categorie,
            ROUND(COUNT(*) * 100.0 / total.total_visiteurs, 2) AS pourcentage
            FROM (
                SELECT 
                    CASE 
                        WHEN ville = 'Bolbec' THEN 'Bolbec'
                        WHEN ville IN (
                            'Alvimare', 'Anquetierville', 'Arelaune-en-Seine', 'Bernières',
                            'Beuzeville-la-Grenier', 'Beuzevillette', 'Bolleville', 'Cléville', 'Cliponville',
                            'Envronville', 'Foucart', 'Grand-Camp', 'Gruchet-le-Valasse', 'Hattenville', 'Heurteauville',
                            'La Frénaye', 'La Trinité-du-Mont', 'Lanquetot', 'Lillebonne', 'Lintot', 'Louvetot',
                            'Maulévrier-Sainte-Gertrude', 'Mélamare', 'Mirville', 'Nointot', 'Norville',
                            'Notre-Dame-de-Bliquetuit', 'Parc-d''Anxtot', 'Petiville', 'Port-Jérôme-sur-Seine', 'Raffetot',
                            'Rives-en-Seine', 'Rouville', 'Saint-Antoine-la-Forêt', 'Saint-Arnoult', 'Saint-Aubin-de-Crétot',
                            'Saint-Eustache-la-Forêt', 'Saint-Gilles-de-Crétot', 'Saint-Jean-de-Folleville',
                            'Saint-Jean-de-la-Neuville', 'Saint-Maurice-d''Ételan', 'Saint-Nicolas-de-la-Haie',
                            'Saint-Nicolas-de-la-Taille', 'Tancarville', 'Terres-de-Caux', 'Trémauville', 'Trouville',
                            'Vatteville-la-Rue', 'Yébleron'
                        ) THEN 'CVS'
                        ELSE 'Hors-CVS'
                    END AS categorie
                FROM 
                    visiteur
            ) AS villes_categorisées,
            (
                SELECT COUNT(*) AS total_visiteurs FROM visiteur
            ) AS total
            GROUP BY 
                categorie, total.total_visiteurs
            ORDER BY 
            pourcentage DESC;";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function getDistanceData()
    {
        $sql = "SELECT ville, COUNT(*) as nb_visiteurs
            FROM visiteur
            GROUP BY ville;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function fetchDataGlobalStats(ActivityRepository $repo, string $debut, string $end): array
    {
        $results = [];

        $activities = $repo->getActivityID();

        for ($i = 0; $i < count($activities); $i++) {
            $id = $activities[$i]['id'];
            $name = $activities[$i]['libelle'];
            $attendance = $repo->getAttendanceByDay($id, $debut, $end);
            $actResults = [];

            $labels = [];
            $dataV = [];
            $dataM = [];
            $dataF = [];
            $dataA = [];

            for ($j = 0; $j < count($attendance); $j++) {
                array_push($labels, $attendance[$j]["Date"]);
                array_push($dataV, $attendance[$j]["nbVisitors"]);
                array_push($dataM, $attendance[$j]["nbHomme"]);
                array_push($dataF, $attendance[$j]["nbFemme"]);
                array_push($dataA, $attendance[$j]["nbAdh"]);
            }
            $actResults['attendance'] = array($labels, $dataV, $dataM, $dataA);

            $results[$name] = $actResults;
        }

        return $results;
    }

    public function CountDistinctVisitors(string $debut, string $end): int {
        $sql = "SELECT COUNT(DISTINCT idVisiteur) AS nbVisiteurs
            FROM estPresent
            WHERE present = 1
            AND date BETWEEN :debut AND :end;";

        $stmt = $this -> conn -> prepare($sql);
        $stmt -> bindParam(':debut', $debut, PDO::PARAM_STR);
        $stmt -> bindParam(':end', $end, PDO::PARAM_STR);
        $stmt-> execute();

        $result = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $result['nbVisiteurs'];
    }

    public function getPSO(): float
    {

        $unitPSO = 0.89;

        $sql = "SELECT DISTINCT COUNT(*)
            FROM visiteur v
            INNER JOIN estPresent eP ON v.id = eP.idVisiteur
            WHERE eP.present = 1;";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();

        $result = $stmt->fetch();
        
        


        return $PSO;
    }
}
