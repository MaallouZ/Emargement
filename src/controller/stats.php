<?php

function stats(ActivityRepository $repoActi, VisitorRepository $repoVis){

    try {
        $idActivity = $_GET["act"];
        $debut = $_GET['debutStat'] ?? date('Y-m-d', strtotime('-1 month'));
        $end = $_GET['endStat'] ?? date('Y-m-d');

        $totalVisitors = $repoVis -> countVisitorsOnPeriod($idActivity, $debut, $end);
        $totalMen = $repoVis -> countMen($idActivity, $debut, $end);
        $totalWomen = $repoVis -> countWomen($idActivity, $debut, $end);
        $attendanceDay = $repoActi -> getAttendanceByDay($idActivity, $debut, $end);
        $attendanceMonth = $repoActi -> getAttendanceByMonth($idActivity, $debut, $end);
        $average = $repoActi -> getAverageVisits($idActivity, $debut, $end);
        
        $labels = [];
        $dataV = [];
        $dataM = [];
        $dataF = [];
        $dataA = [];

        for ($i = 0; $i < count($attendanceDay); $i++) {
            array_push($labels, $attendanceDay[$i]["Date"]);
            array_push($dataV, $attendanceDay[$i]["nbVisitors"]);
            array_push($dataM, $attendanceDay[$i]["nbHomme"]);
            array_push($dataF, $attendanceDay[$i]["nbFemme"]);
            array_push($dataA, $attendanceDay[$i]["nbAdh"]);
        }
        
        $JSONlabels = json_encode($labels);
        $JSONdataV = json_encode($dataV);
        $JSONdataM = json_encode($dataM);
        $JSONdataF = json_encode($dataF);
        $JSONdataA = json_encode($dataA);
        
        $Mlabels = [];
        $MdataV = [];
        $MdataM = [];
        $MdataF = [];
        $MdataA = [];

        for ($i = 0; $i < count($attendanceMonth); $i++) {
            array_push($Mlabels, $attendanceMonth[$i]["Mois"]);
            array_push($MdataV, $attendanceMonth[$i]["nbVisitors"]);
            array_push($MdataM, $attendanceMonth[$i]["nbHomme"]);
            array_push($MdataF, $attendanceMonth[$i]["nbFemme"]);
            array_push($MdataA, $attendanceMonth[$i]["nbAdh"]);
        }
        
        $JSONMlabels = json_encode($Mlabels);
        $JSONMdataV = json_encode($MdataV);
        $JSONMdataM = json_encode($MdataM);
        $JSONMdataF = json_encode($MdataF);
        $JSONMdataA = json_encode($MdataA);

    } catch (PDOException $ex) {
        die("Erreur: " . $ex -> getMessage());
    }
    require 'template/stats.php';
}