<?php

function finalStats(VisitorRepository $visRep){
    
    $visitors = $visRep -> countVisitors();
    $adh = $visRep -> countAdh();

    $year1 = (int) date('Y') - 2;
    $year2 = (int) date('Y') - 1;
    $year3 = date('Y');
    $year1Debut = (string) $year1 . '-09-01';
    $year1End = (string) $year2 . '-08-31';
    $year2Debut = (string) $year2 . '-09-01';
    $year2End = (string) $year3 . '-08-31';

    $attendanceWednesday = $visRep -> getAttendanceWednesday($year1Debut, $year1End, $year2Debut, $year2End);
    $attendanceSaturday = $visRep -> getAttendanceSaturday($year1Debut, $year1End, $year2Debut, $year2End);

    var_dump($attendanceWednesday);

    $labelsW = [];
    $labelsS = [];
    $dataW1 = [];
    $dataW2 = [];
    $dataS1 = [];
    $dataS2 = [];

    for ($i=0; $i < count($attendanceWednesday) ; $i++) { 
        array_push($labelsW, $attendanceWednesday[$i]['mois_nom']);
        array_push($dataW1, $attendanceWednesday[$i]['visiteursY1']);
        array_push($dataW2, $attendanceWednesday[$i]['visiteursY2']);
    }
    
    for ($i=0; $i < count($attendanceSaturday) ; $i++) { 
        array_push($labelsS, $attendanceSaturday[$i]['mois_nom']);
        array_push($dataS1, $attendanceSaturday[$i]['visiteursY1']);
        array_push($dataS2, $attendanceSaturday[$i]['visiteursY2']);
    }

    require 'template/finalStats.php';
}