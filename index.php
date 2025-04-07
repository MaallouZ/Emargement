<?php
session_start();

require 'src/controller/homepage.php';
require 'src/controller/visitors.php';
require 'src/controller/login.php';
require 'src/controller/logout.php';
require 'src/controller/404.php';
require 'src/controller/stats.php';

// Translating date in Fr for all the app
$date = new DateTime();
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE, null, IntlDateFormatter::GREGORIAN, 'EEE d MMMM y');
$formattedDate = $formatter->format($date);

$db = Database::getInstance();
$repoActi = new ActivityRepository($db);
$repoVis = new VisitorRepository($db);

try {
    if (isset($_GET['action'])) {
        $action = $_GET['action'] ?? null;

        if (isset($_SESSION['log']) && $_SESSION['log']) {

            switch ($action) {
                case 'login':
                    login();
                    break;
                case 'homepage':
                    homepage($repoVis);
                    break;
                // case 'finalStats':
                //     finalStats();
                //     break;
                case 'logout':
                    logout();
                    break;
                case 'visitors':
                    visitors($repoVis);
                    break;
                case 'visitorsActivity':
                    visitorsActivity($repoVis);
                    break;
                case 'setValid':
                    setValid($repoVis, $_GET['id'], $_SESSION['user']['perm']);
                    break;
                case 'setUnvalid':
                    setUnvalid($repoVis, $_GET['id'], $_SESSION['user']['perm']);
                    break;
                case 'setPresent':
                    setPresent($repoVis, $_GET['act'], $_GET['id'], $_GET['date'], $_SESSION['user']['perm']);
                    break;
                case 'setAbsent':
                    setAbsent($repoVis, $_GET['act'], $_GET['id'], $_GET['date'], $_SESSION['user']['perm']);
                    break;
                case 'newVisitor':
                    newVisitor($repoVis);
                    break;
                case 'editVisitor':
                    editVisitor($repoVis);
                    break;
                case 'newActivity':
                    newActivity($repoActi);
                    break;
                case 'stat':
                    stats($repoActi, $repoVis);
                    break;
                default:
                    error404();
                    exit();
            }
        } else {
            login();
        }
    } else {
        login();
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
