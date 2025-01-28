<?php
require_once 'src/lib/Database.php';
require_once 'src/model/activity.php';


function printMenu(): string {
    $db = Database::getInstance();
    $repo = new ActivityRepository($db);

    $activite = $repo->getActivityByAccess($_SESSION['user']['id']);
    $nbActivite = $repo->getNbActivity($_SESSION['user']['id']);

    ob_start();
    for ($i=0; $i < $nbActivite; $i++) { 

        // avoid a printing bug
        $jsActivite = str_replace(' ', '-', $activite[$i][1]);
            
        echo ('<!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse'.$jsActivite.'"
                aria-expanded="true" aria-controls="collapse'.$jsActivite.'">
                <i class="fas fa-fw fa-table"></i>
                <span>'.$activite[$i][1].'</span>
            </a>
            <div id="collapse'.$jsActivite.'" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="index.php?action=visitorsActivity&act='.$activite[$i][0].'">Visiteurs</a>'.
                    // <a class="collapse-item" href="historique.php?act='.$activite[$i][0].'">Historique</a>
                    '<a class="collapse-item" href="index.php?action=stat&act='.$activite[$i][0].'">Statistiques</a>
                </div>
            </div>
        </li>
        ');
    }
    return ob_get_clean();
}