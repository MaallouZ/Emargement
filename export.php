<?php
require('db.php');
include('param.php');

shell_exec('sudo rm /var/www/anim.mjcbolbec.fr/statistique.xlsx');

if ($_POST['method'] == 'xlsx') {

    foreach ($_POST as $i => $j) {
        if (strpos($i, 'act') !== false) {
            $activite[$i] = $j;
        }
    }

    $sql = 'SELECT * FROM visiteur ORDER BY IDvisiteur ASC;';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $visitors = $stmt->fetchAll();


    $dataTab = [];
    foreach ($activite as $act => $idAct) {

        $sql = "SELECT V.IDvisiteur, V.nom, V.prenom, V.sexe, YEAR(CURRENT_DATE) - YEAR(V.DDN) AS age, V.ville, V.tel, V.ADH, J.dateJournee, A.libelleActivite, EP.idPresence, EP.present FROM visiteur V JOIN estPresent EP ON V.IDvisiteur = EP.IDvisiteur JOIN activite A ON EP.idActivite = A.idActivite JOIN journée J ON EP.idJournee = J.idJournee WHERE A.idActivite = $idAct AND J.dateJournee BETWEEN '" . $_POST['dateDebut'] . "' AND '". $_POST['dateFin']."' ORDER BY V.IDvisiteur;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data[$result[0]['libelleActivite']] = $result;
    }

    $meta['dateDebut'] = $_POST['dateDebut'];
    $meta['dateFin'] = $_POST['dateFin'];

    $allData['meta'] = $meta;
    $allData['data'] = $data;

    $jsondata = json_encode($allData);

    file_put_contents("data.json", $jsondata);

    shell_exec('pip install xlsxwriter');

    shell_exec('pip install python-dateutil');

    shell_exec('python /var/www/anim.mjcbolbec.fr/main.py');

    sleep(3);
    


    $filename = 'statistique.xlsx';

    header('Content-Description: File Transfer');
    header('Content-Type: octet-stream');
    header('Content-Disposition: attachment; filename="statistique.xlsx');
    header('Expires: 0');
    header('Cache-Control: public');
    header('Content-Transfer-Encoding: binary');
    header('Pragma: public');
    readfile($filename);
    exit();

    $_POST['method'] = NULL;

}
?>