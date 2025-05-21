<?php
$title = "Visiteurs";
ob_start();
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tableau d'appel</h1>
</div>
<!-- Ligne informations -->
<div class="row">
    <!-- Selecteur date -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Date</div>
                        <input type="date" class="form-control" id="date_input" name="date" value="<?= $_GET['date'] ?>" onchange="location = 'index.php?action=visitorsActivity&act=<?= $_GET['act'] ?>&date=' + this.value">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Selecteur date -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total à ce jour</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Selecteur date -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Hommes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $men ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Selecteur date -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Femmes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $women ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <a href="index.php?action=visitorsActivity&act=<?= $_GET['act'] ?>&date=<?= $previousDay->format('Y-m-d') ?>" class="btn btn-secondary btn-circle">
            <i class="fas fa-arrow-left"></i>
        </a>
        <?php if (permHelper::hasEqualPerm("act.export") | permHelper::hasEqualPerm("admin")) :?>
        <a href="index.php?action=getExcel&act=<?= $_GET['act'] ?>&date=<?= $_GET['date'] ?>">
            <button type="button" class="btn btn-primary">
                Liste des présents
            </button>
        </a>
        <?php endif; ?>
        <a href="index.php?action=visitorsActivity&act=<?= $_GET['act'] ?>&date=<?= $nextDay->format('Y-m-d') ?>" class="btn btn-secondary btn-circle">
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

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
                        <th>Action</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Age</th>
                        <th>Sexe</th>
                        <th>ADH</th>
                        <?php
                        if ((permHelper::hasSupPerm("act.histo.edit") || permHelper::hasSupPerm("acc.view")) || permHelper::hasEqualPerm("admin")): ?>
                            <th>Ville</th>
                            <th>Tél</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?= $tab ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
ob_start();
?>

<?php
$modals = ob_get_clean();
require 'template/layout.php';
?>