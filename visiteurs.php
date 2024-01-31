<?php
require("db.php");
include("util.php");

$tabJournée = getJournee($conn);
$tabVisiteur = getVisiteur($conn);
$nbActivite = getNbActivite($conn);
$activite = getActivite($conn);

$act = $_GET['act'];
$jsonAct = json_encode($act);

$sql = "SELECT idPresence, nom, prenom, TIMESTAMPDIFF(YEAR, DDN, CURDATE()) AS age, sexe, ADH, ville, tel, present, DDN, visiteur.IDvisiteur FROM visiteur INNER JOIN estPresent ON estPresent.IDvisiteur = visiteur.IDvisiteur INNER JOIN journée ON estPresent.idJournee = journée.idJournee WHERE journée.dateJournee = :date AND estPresent.idActivite = :act ;";
$stmt = $conn -> prepare($sql);
$stmt -> bindValue(':date', $date, PDO::PARAM_STR);
$stmt -> bindValue(':act',$act, PDO::PARAM_STR);
$stmt -> execute();

$ndata = $stmt -> rowCount();
$data = $stmt -> fetchAll();

$jsonData = json_encode($data);
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Visiteurs</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


        <link href="template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <link href="template/css/sb-admin-2.min.css" rel="stylesheet">
    </head>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <img src="img/MJC BOLBEC_LOGO V1.png" alt="Logo MJC Bolbec" width="75" height="75"/>
                </div>
                <div class="sidebar-brand-text mx-3">Emargement Esport</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tableau de bord</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <?php
            for ($i=0; $i < $nbActivite; $i++) { 
            
            echo ('<!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse'.$activite[$i][1].'"
                    aria-expanded="true" aria-controls="collapse'.$activite[$i][1].'">
                    <i class="fas fa-fw fa-table"></i>
                    <span>'.$activite[$i][1].'</span>
                </a>
                <div id="collapse'.$activite[$i][1].'" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="historique.php?act='.$activite[$i][0].'">Historique</a>
                        <a class="collapse-item" href="visiteurs.php?act='.$activite[$i][0].'">Visiteurs</a>
                        <a class="collapse-item" href="stat.php?act='.$activite[$i][0].'">Statistiques</a>
                    </div>
                </div>
            </li>
            ');
            }
            ?>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </nav>
                <!-- End of Topbar -->

                <!-- Tableau d'appel -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Appel</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr role="row">
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Age</th>
                                        <th>Sexe</th>
                                        <th>ADH</th>
                                        <th>Ville</th>
                                        <th>Tél</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        
                                        for ($i = 0; $i < $ndata; $i++) {
                                            echo "<tr>";
                                            for ($j=1; $j < 8 ; $j++) { 
                                               echo("<td>" . $data[$i][$j] . "</td>");
                                            }
                                            if ($data[$i][8] == 0){
                                                echo('<td><a href="process.php?act='.$act.'&id='.$data[$i][0].'&method=presence" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text">Absent</span></a><a href="#" class="btn btn-secondary btn-circle ms-3" onclick="openModal(\''.json_encode($i).'\')">
                                                <i class="fas fa-pencil-alt"></i>
                                                    <a/></td>');
                                            }
                                            else {
                                                echo('<td><a href="process.php?act='.$act.'&id='.$data[$i][0].'&method=absence" class="btn btn-success btn-icon-split">
                                                    <span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Present</span></a><a href="#" class="btn btn-secondary btn-circle ms-3" onclick="openModal(\''.json_encode($i).'\')">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    <a/></td>');
                                            }
                                            echo "</tr>";
                                            
                                        }
                                    ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- End of Page Wrapper -->
        
        <!-- Modal -->
        <div class="modal fade" id="editVisitor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier ce visiteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="process.php" method="post">
                        <div class="modal-body">

                            <input id="method" name="method" type="hidden" value="editVisitor"/>
                            <input id="idVisitor" name="idVisitor" type="hidden" value=""/>
                            <input id="idAct" name="idAct" type="hidden" value=""/>

                            <div class="mb-3">
                                <label for="sexe_visiteur" class="form-label">Sexe :</label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="M_radio" name="sexe_visiteur" value="M" required>
                                    <span class="form-check-label">Homme</span>
                                </label>

                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="F_radio" name="sexe_visiteur" value="F" required>
                                    <span class="form-check-label">Femme</span>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label for="nom_visiteur" class="form-label">Nom :</label>
                                <input type="text" class="form-control" id="nom_input"  name="nom_visiteur" required>
                            </div>
                            <div class="mb-3">
                                <label for="prenom_visiteur" class="form-label">Prénom :</label>
                                <input type="text" class="form-control" id="prenom_input"  name="prenom_visiteur" required>
                            </div>
                            <div class="mb-3">
                                <label for="DDN_visiteur" class="form-label">Date de naissance (Facultatif) :</label>
                                <input type="date" class="form-control" id="DDN_input"  name="age_visiteur">
                            </div>
                            <div class="mb-3">
                                <label for="ville_visiteur" class="form-label">Ville (Facultatif) :</label>
                                <input type="text" class="form-control" id="ville_input"  name="ville_visiteur" >
                            </div>
                            <div class="mb-3">
                                <label for="tel_visiteur" class="form-label">Téléphone (Facultatif) :</label>
                                <input type="text" class="form-control" id="tel_input"  name="tel_visiteur">
                            </div>

                            <div class="mb-3">
                                <label for="ADH_visiteur" class="form-label">Adhérent :</label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"  id="ADH_radio" name="ADH_visiteur" value="1" required>
                                    <span class="form-check-label">Oui</span>
                                </label>

                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="nonADH_radio" name="ADH_visiteur" value="0" required>
                                    <span class="form-check-label">Non</span>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End of modal -->
        <script>
            var data = JSON.parse('<?php echo $jsonData;?>');
            var act = JSON.parse('<?php echo $jsonAct;?>');
            document.getElementById('idAct').value = act;
            console.log(data);
            
            function openModal(param) {
                var i = JSON.parse(param);
                if (data[i][4] == "M") {
                    document.getElementById("M_radio").checked = true;
                } else {
                    document.getElementById("F_radio").checked = true;
                }

                document.getElementById('idVisitor').value = data[i][10];
                document.getElementById('nom_input').value = data[i][1];
                document.getElementById("prenom_input").value = data[i][2];
                document.getElementById("DDN_input").value = data[i][9];
                document.getElementById("ville_input").value = data[i][6];
                document.getElementById("tel_input").value = data[i][7];

                if (data[i][5] == 1) {
                    document.getElementById("ADH_radio").checked = true;
                }
                else{
                    document.getElementById("nonADH_radio").checked = true;
                }
                
                $('#editVisitor').modal('show');

            }
        </script>

        <!-- Bootstrap core JavaScript-->
        <script src="template/vendor/jquery/jquery.min.js"></script>
        <script src="template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="template/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="template/js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="template/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="template/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="template/js/demo/datatables-demo.js"></script>
    </body>
</html>