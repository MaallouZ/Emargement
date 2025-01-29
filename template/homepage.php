<?php
$title = "Tableau de bord";
ob_start();
?>


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
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $formattedDate ?></div>
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
                            <?= $visitors ?>
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
                            <?= $male ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-mars fa-2x text-gray-300"></i>
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
                            <?= $female ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-venus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 g-4">
    <div class="col text-center">
        <a href="index.php?action=visitors" style="text-decoration: none;">
            <div class="card" style="background-color: #525B76;">
                <i class="fas fa-user fa-8x text-white mt-4"></i>
                <div class="card-body">
                    <h5 class="card-title fw-bolder text-white">Accueil</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col text-center">
        <a href="#" data-bs-toggle="modal" data-bs-target="#" style="text-decoration: none;">
            <div class="card" style="background-color: #DB6C79;">
                <i class="fas fa-laptop fa-8x text-white mt-4"></i>
                <div class="card-body">
                    <h5 class="card-title fw-bolder text-white"><!--Nouvel emprunt-->Bientôt disponible</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col text-center">
        <a href="#" data-bs-toggle="modal" data-bs-target="#new" style="text-decoration: none;">
            <div class="card" style="background-color: #87D68D;">
                <i class="fas fa-plane fa-8x text-white mt-4"></i>
                <div class="card-body">
                    <h5 class="card-title fw-bolder text-white">Bientôt disponible</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col text-center">
        <a href="#" data-bs-toggle="modal" data-bs-target="#" style="text-decoration: none;">
            <div class="card" style="background-color: #8EB1C7;">
                <i class="fas fa-file-export fa-8x text-white mt-4"></i>
                <div class="card-body">
                    <h5 class="card-title fw-bolder text-white"><!--Export format Excel-->Bientôt disponible</h5>
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
<?php
$content = ob_get_clean();
ob_start();
?>
<!-- Modals -->
<div class="modal fade" id="newActivity" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une activité</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php?action=newActivity" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="method" value="addActivite">

                    <div class="mb-3">
                        <label for="nomActv">Nom de l'activité :</label>
                        <input type="text" class="form-control" id="libelleAct_input" name="libelleAct" required>
                    </div>
                    <div>
                        <label for="dateDebut">Date de début :</label>
                        <input type="date" class="form-control" id="dateDebut_input" name="dateDebut" required>
                    </div>
                    <div>
                        <label for="dateFin">Date de fin :</label>
                        <input type="date" class="form-control" id="dateFin_input" name="dateFin" required>
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
<!-- Modal location -->
<div class="modal fade" id="locationForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="process.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="method" value="newLocation">
                    <input type="hidden" id="idVisLoc" name="idVisLoc">
                    <div class="mb-3">
                        <label for="nomVisLoc">Nom du visiteur: </label>
                        <input type="text" class="form-control" id="nomVisLoc" name="nomVisLoc" placeholder="Nom" autocomplete="off" required>
                    </div>

                    <div class="mb-3">
                        <label for="refMat">Materiel emprunté: </label>
                        <select class="form-select" name="idMat" multiple aria-label="multiple select example" required>
                            <?php
                            // $sql = "SELECT idMateriel, referenceMateriel FROM materiel WHERE estPrete = 0;";
                            // $stmt = $conn->prepare($sql);
                            // $stmt->execute();
                            // $listMat = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // foreach ($listMat as $row) {
                            //     echo ('<option value="' . $row['idMateriel'] . '">' . $row['referenceMateriel'] . '</option>');
                            // }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dateRetour">Date de retour estimé: </label>
                        <input type="date" id="dateRetour" name="dateRetour" required>
                    </div>

                    <div class="mb-3">
                        <label for="etat">Etat actuel : </label>
                        <textarea class="form-control" id="etatMat" name="etatMat"></textarea>
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
<!-- Modal nouveau visiteur -->
<div class="modal fade" id="newVisitor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un nouveau visiteur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php?action=newVisitor" method="post">
                <div class="modal-body">

                    <input id="method" name="method" type="hidden" value="addVisitor" />

                    <div class="mb-3">
                        <label for="sexe_visiteur" class="form-label">Sexe :</label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexe_visiteur" value="M" required>
                            <span class="form-check-label">Homme</span>
                        </label>

                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexe_visiteur" value="F" required>
                            <span class="form-check-label">Femme</span>
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="nom_visiteur" class="form-label">Nom :</label>
                        <input type="text" class="form-control" id="nom_input" name="nom_visiteur" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom_visiteur" class="form-label">Prénom :</label>
                        <input type="text" class="form-control" id="prenom_input" name="prenom_visiteur" required>
                    </div>
                    <div class="mb-3">
                        <label for="DDN_visiteur" class="form-label">DDN (Facultatif) :</label>
                        <input type="date" class="form-control" id="age_input" name="DDN_visiteur">
                    </div>
                    <div class="mb-3">
                        <label for="ville_visiteur" class="form-label">Ville (Facultatif) :</label>
                        <input type="text" class="form-control" id="ville_input" name="ville_visiteur">
                    </div>
                    <div class="mb-3">
                        <label for="tel_visiteur" class="form-label">Téléphone (Facultatif) :</label>
                        <input type="text" class="form-control" id="tel_input" name="tel_visiteur">
                    </div>

                    <div class="mb-3">
                        <label for="ADH_visiteur" class="form-label">Adhérent :</label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ADH_visiteur" value="1" required>
                            <span class="form-check-label">Oui</span>
                        </label>

                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ADH_visiteur" value="0" required>
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

<!-- Modal Export XLSX -->
<div class="modal fade" id="exportXlsx" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exporter les données en fichier Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="export.php" method="POST">
                <div class="modal-body">
                    <input id="method" name="method" type="hidden" value="xlsx" />

                    <div class="mb-3">
                        <label for="activite_export" class="form-label">Activités :</label>
                        <?php
                        // $stmt = $conn->prepare("SELECT a.idActivite, a.libelleActivite FROM activite AS a WHERE a.enabled = 1;");
                        // $stmt->execute();
                        // $enabledAct = $stmt->fetchAll();
                        // $nbColumn = $stmt->rowCount();

                        // for ($i = 0; $i < $nbColumn; $i++) {
                        //     echo ('<label class="form-check form-check-inline">');
                        //     echo ('<input class="form-check-input" type="checkbox" name="act' . $i . '" value="' . $enabledAct[$i][0] . '">');
                        //     echo ('<span>' . $enabledAct[$i][1] . '</span>');
                        //     echo ('</label>');
                        // }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="DDN_visiteur" class="form-label">Période :</label>
                        </br>
                        <span>Début :</span>
                        <input type="date" class="form-control" id="dateDebut" name="dateDebut">
                        </br>
                        <span>Fin :</span>
                        <input type="date" class="form-control" id="dateFin" name="dateFin">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Exporter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of modals -->

<script>
    const listVisitors = JSON.parse('<?php echo $visitorEncode; ?>');

    $(document).ready(function() {
        $('#nomVisLoc').typeahead({
            source: listVisitors.map(function(visiteur) {
                return visiteur.nom + ' ' + visiteur.prenom;
            }),
            items: 4
        });

        $('#nomVisLoc').on('change', function() {
            const selectedValue = $(this).val();
            const selectedVis = listVisitors.find(function(visiteur) {
                return selectedValue === visiteur.nom + ' ' + visiteur.prenom;
            });

            if (selectedVis) {
                $('#idVisLoc').val(selectedVis.IDVisiteur);
            } else {
                // Réinitialiser le champ caché si aucune correspondance n'est trouvée
                $('#idVisLoc').val('');
            }
        });
    });
</script>

<?php
$modals = ob_get_clean();
require 'template/layout.php';
?>