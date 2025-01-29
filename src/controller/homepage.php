<?php
require_once 'src/model/activity.php';
require_once 'src/lib/Database.php';
require_once 'src/model/visitors.php';


function homepage(VisitorRepository $repo){
    global $formattedDate;

    $visitors = $repo -> getAllVisitsOnDay();
    $male = $repo -> getMaleVisitsOnDay();
    $female = $repo -> getFemaleVisitsOnDay();

    require 'template/homepage.php';
}

function newActivity(ActivityRepository $repo){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $libelle = htmlspecialchars($_POST['libelleAct']);
        $dateDebut = htmlspecialchars($_POST["dateDebut"]);
        $dateFin = htmlspecialchars($_POST["dateFin"]);
        $repo -> newActivity($libelle, $dateDebut, $dateFin);

        header('Location: index.php?action=homepage');
    }
}