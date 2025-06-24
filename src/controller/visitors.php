<?php
require_once 'src/model/activity.php';
require_once 'src/model/visitors.php';
require_once 'src/lib/Database.php';
require_once 'vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function visitors(VisitorRepository $repo){
    
    if (permHelper::hasBetweenPerm("SC.acc.pres","acc.add") || permHelper::hasEqualPerm("act.view") || permHelper::hasEqualPerm("admin")){
        if (permHelper::hasEqualPerm('SC.acc.pres')) {
            $listVisitors = $repo -> getMinVisitors();
            $jsonData = json_encode($listVisitors->fetchAll());
            $tab = $repo -> printTabVisitors($listVisitors);
            require 'template/visitors.php';
        }
        else {
            $listVisitors = $repo -> getVisitors();
            $jsonData = json_encode($listVisitors->fetchAll());
            $tab = $repo -> printTabVisitors($listVisitors);
            require 'template/visitors.php';
        }
    }
    else {
        header('index.php?action=homepage');
    }
}

function visitorsActivity(VisitorRepository $repo){
    $activityID = $_GET['act'];
    $date = $_GET['date'];
    $nextDay = new DateTime($date);
    $nextDay -> modify('+1 day');
    $previousDay = new DateTime($date);
    $previousDay -> modify('-1 day');
    $total = $repo -> getAllVisitsOnDayByActivity($activityID, $date);
    $men = $repo -> getMaleVisitsOnDayByActivity($activityID, $date);
    $women = $repo -> getFemaleVisitsOnDayByActivity($activityID, $date);
    if (permHelper::hasSupPerm("act.histo.edit") || permHelper::hasEqualPerm("admin")) {
        $listStmt = $repo -> getVisitorsByActivity($activityID, $date);
        $listStmt -> execute();
        $tab = $repo -> printTabVisitorsActivity($activityID, $listStmt);
    } else {
        $listStmt = $repo -> getMinVisitorsByActivity($activityID, $date);
        $listStmt -> execute();
        $tab = $repo -> printTabVisitorsActivity($activityID, $listStmt);
    }

    
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

function setPresent(VisitorRepository $repo, int $act, int $id, string $date){
    if ((isset($act) && $act !== 0) && (isset($date) && $date !== '0000-00-00')) {
        if (isset($id) && $id !== 0) {
            $repo -> setPresent($id);
            header('Location: index.php?action=visitorsActivity&act=' . $_GET['act'].'&date='.$date);
        }
        else {
            throw new Exception("L'identifiant du visiteur n'est pas reconnu.", 1);
        }
    }
    else {
        error404();
    }
}

function setAbsent(VisitorRepository $repo, int $act, int $id, string $date){
    if ((isset($act) && $act !== 0) && (isset($date) && $date !== '0000-00-00')) {
        if (isset($id) && $id !== 0) {
            $repo -> setAbsent($id);
            header('Location: index.php?action=visitorsActivity&act=' . $_GET['act'].'&date='.$date);
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
        header('Location: index.php?action=visitors');
    }
}

function setValid(VisitorRepository $repo, int $idVisitor, int $perm){
    if ($perm > 3 || $perm < -1) {
        if (isset($idVisitor) && $idVisitor !== 0) {
            $repo -> setValid($idVisitor);
            header('Location: index.php?action=visitors');
        }
        else {
            throw new Exception("L'identifiant du visiteur n'est pas reconnu.", 1);
        }
    } else {
        throw new Exception("Vous n'avez pas cette permission");
    }
}

function setUnvalid(VisitorRepository $repo, int $idVisitor, int $perm){

    if ($perm > 3 || $perm < -1) {
        if (isset($idVisitor) && $idVisitor !== 0) {
            $repo -> setUnvalid($idVisitor);
            header('Location: index.php?action=visitors');
        }
        else {
            throw new Exception("L'identifiant du visiteur n'est pas reconnu.", 1);
        }
    } else {
        throw new Exception("Vous n'avez pas cette permission");
    }
}

function getExcel(ActivityRepository $repo, int $idActivite, string $date){
    $data = $repo->getExcelData($idActivite, $date);

    $actName = $repo -> getActivityName($idActivite);
    $title = (string) $actName . ' ' . $date;


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setTitle($title);

    $headers = ['Nom', 'Prénom', 'Âge', 'Sexe', 'ADH', 'Ville'];
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $col++;
    }

    $row = 2;
    foreach ($data as $personne) {
        $sheet->setCellValue('A' . $row, $personne['nom']);
        $sheet->setCellValue('B' . $row, $personne['prenom']);
        $sheet->setCellValue('C' . $row, $personne['age']);
        $sheet->setCellValue('D' . $row, $personne['sexe']);
        $sheet->setCellValue('E' . $row, $personne['ADH']);
        $sheet->setCellValue('F' . $row, $personne['ville']);
        $row++;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}