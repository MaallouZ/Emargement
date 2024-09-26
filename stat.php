<?php
require("db.php");
include("util.php");
session_start();

addDay($conn);

$tabJournée = getJournee($conn);
$tabVisiteur = getVisiteur($conn);

if ($_SESSION["log"]) {
    if (isset($_GET['act'])) {
?>

        <!DOCTYPE html>

        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>Statistiques</title>
                <meta name="description" content="">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script src="freq.js"></script>
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
                            <!-- <i class="fas fa-laugh-wink"></i> -->
                            <img src="img/MJC BOLBEC_LOGO V1.png" alt="Logo MJC Bolbec" width="75" height="75"/>
                        </div>
                        <div class="sidebar-brand-text mx-3">Emargement</div>
                    </a>

                    <!-- Divider -->
                    <hr class="sidebar-divider my-0">

                    <!-- Nav Item - Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Tableau de bord</span>
                        </a>
                        <a class="nav-link" href="emprunt.php">
                        <i class="fas fa-fw fa-list-alt"></i>
                            <span>Emprunts</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Interface
                    </div>

                    <?php
                    printActivite($conn);
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
                        </nav>
                        <!-- End of Topbar -->

                        <div class="container-fluid">

                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h1 class="h3 mb-0 text-gray-800">Statistiques</h1>
                            </div>

                            <div class="row">
                                <form id="formStat">

                                    <input type="hidden" name="idActivite" value="<?php echo $_GET['act']; ?>">
                                    
                                    <div class="mb-3">
                                        <label for="dateDebut">Date de début :</label>
                                        <input type="date" class="form-control" id="dateDebut_input" name="dateDebut" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dateFin">Date de fin :</label>
                                        <input type="date" class="form-control" id="dateFin_input" name="dateFin" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Séléctionner</button>

                                </form>
                            </div>

                            <div class="row">

                                <!-- Total Visiteurs -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Total de visiteurs</div>
                                                    <div id="totalVisiteur" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Total Homme -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Total d'hommes</div>
                                                    <div id="total_H" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Total Femme -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"> Total de femmes</div>
                                                    <div id="total_F" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Moyenne -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"> Moyenne de visites par jour</div>
                                                    <div id="moyenne" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Area Chart -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Fréquentation</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="freqChart"></canvas>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- End of Page Wrapper -->

                <!-- Bootstrap core JavaScript-->
                <script src="template/vendor/jquery/jquery.min.js"></script>
                <script src="template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Core plugin JavaScript-->
                <script src="template/vendor/jquery-easing/jquery.easing.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="template/js/sb-admin-2.min.js"></script>
                <script>
                    $('#formStat').submit(function(e){
                        
                        // interception du formulaire et sérialisation des données
                        e.preventDefault();
                        var formData = $(this).serialize();
                        console.log(formData);

                        // Envoi par AJAX
                        $.ajax({
                            url:'loadData.php',
                            type:'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response){
                                if (response.status === "success") {
                                    $("#totalVisiteur").text(response.totalVisiteur);
                                    $("#total_H").text(response.total_H);
                                    $("#total_F").text(response.total_F);
                                    $("#moyenne").text(response.moyenne);

                                    console.log(response.labels);
                                    updateChart(response.labels, response.data);
                                } else {
                                    
                                }
                            },
                            error: function(xhr,status,error){
                                console.error("Erreur AJAX : ", status, error);
                            }
                        })
                    })
                </script>
            </body>
        </html>
<?php
    }
    else {
        header('Location: https://anim.mjcbolbec.fr/index.php');
    }
}
else {
    header('Location: https://anim.mjcbolbec.fr/login.php');
}
?>