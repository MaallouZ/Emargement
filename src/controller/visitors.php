<?php
require_once 'src/model/activity.php';
require_once 'src/model/visitors.php';
require_once 'src/lib/Database.php';

function visitors(VisitorRepository $repo){
    $listVisitors = $repo -> getVisitors();
    $jsonData = json_encode($listVisitors->fetchAll());
    $tab = $repo -> printTabVisitors($listVisitors);
    require 'template/visitors.php';
}

function visitorsActivity(VisitorRepository $repo){
    $activityID = $_GET['act'];
    $listStmt = $repo -> getVisitorsByActivity($activityID);
    $listStmt -> execute();
    $tab = $repo -> printTabVisitorsActivity($activityID, $listStmt);
    require 'template/visitorsActivity.php';
}

function newVisitor(VisitorRepository $repo){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sexe = $_POST["new_sex"];
        $nom = htmlspecialchars($_POST["new_nom"]);
        $prenom = htmlspecialchars($_POST["new_prenom"]);
        $DDN = htmlspecialchars($_POST["new_DDN"]) ?? null;
        $ville = htmlspecialchars($_POST["new_ville"]) ?? null;
        $tel = htmlspecialchars($_POST["new_tel"]) ?? null;
        $ADH = $_POST["new_ADH"];
        $repo -> newVisitor($sexe, $nom, $prenom, $DDN, $ville, $tel, $ADH);

        header('Location: index.php?action=visitors');
    }
}

function setPresent(VisitorRepository $repo, int $act, int $id){
    if (isset($act) && $act !== 0) {
        if (isset($id) && $id !== 0) {
            $repo -> setPresent($id);
            header('Location: index.php?action=visitorsActivity&act=' . $_GET['act']);
        }
        else {
            throw new Exception("L'identifiant du visiteur n'est pas reconnu.", 1);
        }
    }
    else {
        error404();
    }
}

function setAbsent(VisitorRepository $repo, int $act, int $id){
    if (isset($act) && $act !== 0) {
        if (isset($id) && $id !== 0) {
            $repo -> setAbsent($id);
            header('Location: index.php?action=visitorsActivity&act=' . $_GET['act']);
        }
        else {
            throw new Exception("L'identifiant du visiteur n'est pas reconnu.", 1);
        }
    }
    else {
        error404();
    }
}

function editVisitor(VisitorRepository $repo){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idVisitor = $_POST['idVisitor'];
        $sexe = $_POST["sexe_visiteur"];
        $nom = htmlspecialchars($_POST["nom_visiteur"]);
        $prenom = htmlspecialchars($_POST["prenom_visiteur"]);
        $DDN = htmlspecialchars($_POST["DDN_visiteur"]);
        $ville = htmlspecialchars($_POST["ville_visiteur"]);
        $tel = htmlspecialchars($_POST["tel_visiteur"]);
        $ADH = $_POST["ADH_visiteur"];
        $repo -> editVisitor($sexe, $nom, $prenom, $DDN, $ville, $tel, $ADH, $idVisitor);

        $act = $_POST['idAct'];
        header('Location: index.php?action=visitors&act='.$act);
    }
}

function setValid(VisitorRepository $repo, int $idVisitor){
    if (isset($idVisitor) && $idVisitor !== 0) {
        $repo -> setValid($idVisitor);
        header('Location: index.php?action=visitors');
    }
    else {
        throw new Exception("L'identifiant du visiteur n'est pas reconnu.", 1);
    }
}

function setUnvalid(VisitorRepository $repo, int $idVisitor){
    if (isset($idVisitor) && $idVisitor !== 0) {
        $repo -> setUnvalid($idVisitor);
        header('Location: index.php?action=visitors');
    }
    else {
        throw new Exception("L'identifiant du visiteur n'est pas reconnu.", 1);
    }
}