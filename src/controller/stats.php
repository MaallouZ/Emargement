<?php

function stats(ActivityRepository $repoActi, VisitorRepository $repoVis){

    try {
        $idActivity = $_GET["act"];
        $debut = $_GET['debutStat'] ?? date('Y-m-d', strtotime('-1 month'));
        $end = $_GET['endStat'] ?? date('Y-m-d');

        $totalVisitors = $repoVis -> countVisitorsOnPeriod($idActivity, $debut, $end);
        $totalMen = $repoVis -> countMen($idActivity, $debut, $end);
        $totalWomen = $repoVis -> countWomen($idActivity, $debut, $end);
        $attendance = $repoActi -> getAttendance($idActivity, $debut, $end);
        $average = $repoActi -> getAverageVisits($idActivity, $debut, $end);
    
        $labels = [];
        $data = [];
    
        for ($i = 0; $i < count($attendance); $i++) {
            array_push($labels, $attendance[$i]["Date"]);
            array_push($data, $attendance[$i]["nbVisitors"]);
        }

        $JSONlabels = json_encode($labels);
        $JSONdata = json_encode($data);
    } catch (PDOException $ex) {
        "Erreur: " . $ex -> getMessage();
    }
    require 'template/stats.php';
}