<?php
require("db.php");
include("util.php");

$activite = getActivite($conn);
$nbActivite = getNbActivite($conn);
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Tableau de bord</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


        <link href="template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href="template/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">

        <link href="style.css" rel="stylesheet">
    </head>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
                    </div>

                    <div class="row">
                        <!-- Date du jour -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Date du jour</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $date; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Visiteurs -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Visiteurs</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $sql = "SELECT COUNT(*) FROM estPresent INNER JOIN journée ON estPresent.idJournee = journée.idJournee WHERE dateJournee = :date AND present = 1;";
                                                    $req = $conn -> prepare($sql);
                                                    $req -> bindValue(":date",$date,PDO::PARAM_STR);
                                                    $req->execute();

                                                    $visitors = $req -> fetch()[0];
                                                    echo $visitors;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- HOMME -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Homme</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $sql = "SELECT COUNT(*) FROM estPresent INNER JOIN journée ON estPresent.idJournee = journée.idJournee INNER JOIN visiteur ON estPresent.IDvisiteur = visiteur.IDvisiteur WHERE dateJournee = :date AND present = 1 AND sexe = 'M';";
                                                    $stmt = $conn -> prepare($sql);
                                                    $stmt -> bindValue(":date", $date, PDO::PARAM_STR);
                                                    $stmt -> execute();

                                                    $homme = $stmt -> fetch()[0];
                                                    echo $homme;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FEMME -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Femme</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $sql = "SELECT COUNT(*) FROM estPresent INNER JOIN journée ON estPresent.idJournee = journée.idJournee INNER JOIN visiteur ON estPresent.IDvisiteur = visiteur.IDvisiteur WHERE dateJournee = :date AND present = 1 AND sexe = 'F';";
                                                    $stmt = $conn -> prepare($sql);
                                                    $stmt -> bindValue(":date", $date, PDO::PARAM_STR);
                                                    $stmt -> execute();

                                                    $femme = $stmt -> fetch()[0];
                                                    echo $femme;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <div class="col text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#newVisitor" style="text-decoration: none;">
                                <div class="card" style="background-color: #525B76;">
                                    <i class="fas fa-user fa-8x text-white mt-4"></i>
                                    <div class="card-body">
                                        <h5 class="card-title fw-bolder text-white">Nouveau visiteur</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#locationForm" style="text-decoration: none;">
                                <div class="card" style="background-color: #DB6C79;">
                                    <i class="fas fa-laptop fa-8x text-white mt-4"></i>
                                    <div class="card-body">
                                        <h5 class="card-title fw-bolder text-white">Location</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col text-center">
                            <a href="#" data-bs-toggle="modal"  data-bs-target="#newActivite" style="text-decoration: none;">
                                <div class="card" style="background-color: #87D68D;">
                                    <i class="fas fa-plane fa-8x text-white mt-4"></i>
                                    <div class="card-body">
                                        <h5 class="card-title fw-bolder text-white">Nouvelle activité</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exportXLS" style="text-decoration: none;">
                                <div class="card" style="background-color: #8EB1C7;">
                                    <i class="fas fa-file-export fa-8x text-white mt-4"></i>
                                    <div class="card-body">
                                        <h5 class="card-title fw-bolder text-white">Export format Excel</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- End of Page Wrapper -->

        <!-- Modals -->
        
        <div class="modal fade" id="newVisitor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un nouveau visiteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="process.php" method="post">
                        <div class="modal-body">

                            <input id="method" name="method" type="hidden" value="addVisitor"/>
                        
                            <div class="mb-3">
                                <label for="sexe_visiteur" class="form-label">Sexe :</label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"  name="sexe_visiteur" value="M" required>
                                    <span class="form-check-label">Homme</span>
                                </label>

                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"  name="sexe_visiteur" value="F" required>
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
                                <label for="DDN_visiteur" class="form-label">DDN (Facultatif) :</label>
                                <input type="date" class="form-control" id="age_input"  name="DDN_visiteur">
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
                                    <input class="form-check-input" type="radio"  name="ADH_visiteur" value="1" required>
                                    <span class="form-check-label">Oui</span>
                                </label>

                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"  name="ADH_visiteur" value="0" required>
                                    <span class="form-check-label">Non</span>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End of modals -->

        <!-- Bootstrap core JavaScript-->
        <script src="template/vendor/jquery/jquery.min.js"></script>
        <script src="template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="template/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="template/js/sb-admin-2.min.js"></script>

        <?php echo "pute"; ?>
    </body>
</html>