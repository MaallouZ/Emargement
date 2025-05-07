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
        $dataV = [];
        $dataM = [];
        $dataF = [];
        $dataA = [];

        for ($i = 0; $i < count($attendance); $i++) {
            array_push($labels, $attendance[$i]["Date"]);
            array_push($dataV, $attendance[$i]["nbVisitors"]);
            array_push($dataM, $attendance[$i]["nbHomme"]);
            array_push($dataF, $attendance[$i]["nbFemme"]);
            array_push($dataA, $attendance[$i]["nbAdh"]);
        }

        $labelsM = [];
        

        $JSONlabels = json_encode($labels);
        $JSONdataV = json_encode($dataV);
        $JSONdataM = json_encode($dataM);
        $JSONdataF = json_encode($dataF);
        $JSONdataA = json_encode($dataA);

    } catch (PDOException $ex) {
        "Erreur: " . $ex -> getMessage();
    }
    require 'template/stats.php';
}