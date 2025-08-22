<?php
require_once 'src/lib/GeoHelper.php';
require_once 'src/model/stats.php';

function finalStats(ActivityRepository $repoActi, VisitorRepository $visRep, StatsRespository $statRep)
{

    $visitors = $visRep->countVisitors();
    $adh = $visRep->countAdh();

    $year1 = (int) date('Y') - 2;
    $year2 = (int) date('Y') - 1;
    $year3 = date('Y');
    $yearString1 = json_encode($year1 . "-" . $year2);
    $yearString2 = json_encode($year2 . "-" . $year3);
    $year1Debut = (string) $year1 . '-09-01';
    $year1End = (string) $year2 . '-08-31';
    $year2Debut = (string) $year2 . '-09-01';
    $year2End = (string) $year3 . '-08-31';

    $visits = $statRep->CountDistinctVisitors($year2Debut,$year2End);

    $year1 = json_encode($year1);
    $year2 = json_encode($year2);
    $year3 = json_encode($year3);

    $attendanceWednesday = $statRep->getAttendanceWednesday($year1Debut, $year1End, $year2Debut, $year2End);
    $attendanceSaturday = $statRep->getAttendanceSaturday($year1Debut, $year1End, $year2Debut, $year2End);

    $labelsW = [];
    $labelsS = [];
    $dataW1 = [];
    $dataW2 = [];
    $dataS1 = [];
    $dataS2 = [];

    for ($i = 0; $i < count($attendanceWednesday); $i++) {
        array_push($labelsW, $attendanceWednesday[$i]['mois_nom']);
        array_push($dataW1, $attendanceWednesday[$i]['visiteursY1']);
        array_push($dataW2, $attendanceWednesday[$i]['visiteursY2']);
    }

    for ($i = 0; $i < count($attendanceSaturday); $i++) {
        array_push($labelsS, $attendanceSaturday[$i]['mois_nom']);
        array_push($dataS1, $attendanceSaturday[$i]['visiteursY1']);
        array_push($dataS2, $attendanceSaturday[$i]['visiteursY2']);
    }

    $JSONlabelsW = json_encode($labelsW);
    $JSONlabelsS = json_encode($labelsS);
    $JSONdataW1 = json_encode($dataW1);
    $JSONdataW2 = json_encode($dataW2);
    $JSONdataS1 = json_encode($dataS1);
    $JSONdataS2 = json_encode($dataS2);

    $poleAttendance = $statRep->poleAttendance($year2Debut, $year2End);
    $poleLib = [];
    $poleData = [];

    for ($i = 0; $i < count($poleAttendance); $i++) {
        array_push($poleLib, $poleAttendance[$i]['libelle']);
        array_push($poleData, $poleAttendance[$i]['pourcentage_presence']);
    }
    $JSONpoleLib = json_encode($poleLib);
    $JSONpoleData = json_encode($poleData);

    $cityChart = $statRep->getCitiesChart();
    $city = [];
    $cityData = [];

    for ($i = 0; $i < count($cityChart); $i++) {
        array_push($city, $cityChart[$i]['ville']);
        array_push($cityData, $cityChart[$i]['pourcentage']);
    }
    $JSONcity = json_encode($city);
    $JSONcityData = json_encode($cityData);

    $stats = $statRep->getDistanceData();

    $citiesJson = GeoHelper::loadCityCoordinates('data/geo.json');
    $coordinatesMap = GeoHelper::getCoordinatesByCity($citiesJson);

    if (!isset($coordinatesMap['Bolbec'])) {
        die('Coordonnées de Bolbec introuvables.');
    }

    [$lonB, $latB] = $coordinatesMap['Bolbec'];

    $distances = [
        'Bolbec' => 0,
        '-10km' => 0,
        '-20km' => 0,
        '-30km' => 0,
    ];

    foreach ($stats as $entry) {
        $ville = $entry['ville'];
        $count = (int)$entry['nb_visiteurs'];

        if (!isset($coordinatesMap[$ville])) {
            continue;
        }

        [$lonV, $latV] = $coordinatesMap[$ville];
        $dist = GeoHelper::haversine($latB, $lonB, $latV, $lonV);

        if (strtolower($ville) === 'bolbec') {
            $distances['Bolbec'] += $count;
        } elseif ($dist <= 10) {
            $distances['-10km'] += $count;
        } elseif ($dist <= 20) {
            $distances['-20km'] += $count;
        } elseif ($dist <= 30) {
            $distances['-30km'] += $count;
        }
    }

    $JSONdist = json_encode($distances);

    $activityData = $statRep -> fetchDataGlobalStats($repoActi, $year2Debut, $year2End);

    $JSONactivityData = json_encode($activityData);


    require 'template/finalStats.php';
}
