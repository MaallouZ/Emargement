<?php
$title = "Statistiques";
ob_start();
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Statistiques</h1>
</div>

<div class="row">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Période</h6>
        </div>
        <div class="card-body">
            <form action="index.php" method="GET">
                <input type="hidden" name="action" value="stat">
                <input type="hidden" name="act" value="<?= htmlspecialchars($_GET['act']) ?>">
                <div class="d-flex align-items-end flex-wrap gap-3">
                    <div>
                        <label for="debutStat" class="form-label">Date de début :</label>
                        <input type="date" class="form-control" id="debutStat" name="debutStat">
                    </div>
                    <div>
                        <label for="endStat" class="form-label">Date de fin :</label>
                        <input type="date" class="form-control" id="endStat" name="endStat">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Total Visiteurs -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total de visiteurs</div>
                        <div id="totalVisitors" class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalVisitors ?></div>
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
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total d'hommes</div>
                        <div id="totalMen" class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalMen ?></div>
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
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total de femmes</div>
                        <div id="totalWomen" class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalWomen ?></div>
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
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Moyenne de visites par jour</div>
                        <div id="average" class="h5 mb-0 font-weight-bold text-gray-800"><?= $average ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Area Chart -->
<div class="card shadow mb-9">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Fréquentation</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Options:</div>
                <a class="dropdown-item" href="#" onclick="updateStatChart(labels, dataV, dataM, dataF, dataA);">Par jour</a>
                <a class="dropdown-item" href="#" onclick="updateStatChart(Mlabels, MdataV, MdataM, MdataF, MdataA);">Par mois</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="chart-area">
            <canvas id="attendanceChart"></canvas>
        </div>
        <hr>
    </div>
</div>

<?php
$content = ob_get_clean();
ob_start();
?>
<script>
    // get visitors datas
    var labels = JSON.parse('<?= $JSONlabels ?>');
    var dataV = JSON.parse('<?= $JSONdataV ?>');
    var dataM = JSON.parse('<?= $JSONdataM ?>');
    var dataF = JSON.parse('<?= $JSONdataF ?>');
    var dataA = JSON.parse('<?= $JSONdataA ?>');

    var Mlabels = JSON.parse('<?= $JSONMlabels ?>');
    var MdataV = JSON.parse('<?= $JSONMdataV ?>');
    var MdataM = JSON.parse('<?= $JSONMdataM ?>');
    var MdataF = JSON.parse('<?= $JSONMdataF ?>');
    var MdataA = JSON.parse('<?= $JSONMdataA ?>');

    updateStatChart(labels, dataV, dataM, dataF, dataA);
</script>
<?php
$modals = ob_get_clean();
include 'template/layout.php';
?>