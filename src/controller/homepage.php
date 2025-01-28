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

function newVisitor(VisitorRepository $repo){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sexe = $_POST["sexe_visiteur"];
        $nom = htmlspecialchars($_POST["nom_visiteur"]);
        $prenom = htmlspecialchars($_POST["prenom_visiteur"]);
        $DDN = htmlspecialchars($_POST["DDN_visiteur"]);
        $ville = htmlspecialchars($_POST["ville_visiteur"]);
        $tel = htmlspecialchars($_POST["tel_visiteur"]);
        $ADH = $_POST["ADH_visiteur"];
        $repo -> newVisitor($sexe, $nom, $prenom, $DDN, $ville, $tel, $ADH);

        header('Location: index.php?action=homepage');
    }
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