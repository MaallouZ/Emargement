<?php

function stats(ActivityRepository $repoActi, VisitorRepository $repoVis){

    try {
        $idActivity = $_GET["act"];

        $totalVisitors = $repoVis -> countVisitorsOnPeriod($idActivity);
        $totalMen = $repoVis -> countMen($idActivity);
        $totalWomen = $repoVis -> countWomen($idActivity);
        $attendance = $repoActi -> getAttendance($idActivity);
        $average = $repoActi -> getAverageVisits($idActivity);
    
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