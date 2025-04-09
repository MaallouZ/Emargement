<?php
$title = "Accueil";
ob_start();
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Accueil</h1>
</div>
<?php if(permHelper::hasEqualPerm('acc.add') || permHelper::hasEqualPerm('act.view') ||permHelper::hasEqualPerm('admin')) :?>
<a href="#" data-bs-toggle="modal" data-bs-target="#newVisitor" class="btn btn-primary btn-icon-split">
    <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
    </span>
    <span class="text">Ajouter un visiteur</span>
</a>
<?php endif ?>
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
                        <?php if (permHelper::hasDiffPerm('SC.acc.pres')) :?>
                        <th>Ville</th>
                        <th>Tél</th>
                        <?php endif ?>
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

<!-- Modal -->
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
                            <input class="form-check-input" type="radio" name="new_sex" value="M" required>
                            <span class="form-check-label">Homme</span>
                        </label>

                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="new_sex" value="F" required>
                            <span class="form-check-label">Femme</span>
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="nom_visiteur" class="form-label">Nom :</label>
                        <input type="text" class="form-control" id="nom_input" name="new_nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom_visiteur" class="form-label">Prénom :</label>
                        <input type="text" class="form-control" id="prenom_input" name="new_prenom" required>
                    </div>
                    <div class="mb-3">
                        <label for="DDN_visiteur" class="form-label">Date de Naissance :</label>
                        <input type="date" class="form-control" id="age_input" name="new_DDN" required>
                    </div>
                    <div class="mb-3">
                        <label for="ville_visiteur" class="form-label">Ville :</label>
                        <input type="text" class="form-control" id="ville_input" name="new_ville" required>
                    </div>
                    <div class="mb-3">
                        <label for="tel_visiteur" class="form-label">Téléphone :</label>
                        <input type="text" class="form-control" id="tel_input" name="new_tel" required>
                    </div>

                    <div class="mb-3">
                        <label for="ADH_visiteur" class="form-label">Adhérent :</label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="new_ADH" value="1" required>
                            <span class="form-check-label">Oui</span>
                        </label>

                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="new_ADH" value="0" required>
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

<div class="modal fade" id="editVisitor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier ce visiteur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php?action=editVisitor" method="post">
                <div class="modal-body">

                    <input id="method" name="method" type="hidden" value="editVisitor" />
                    <input id="edit_idVisitor" name="idVisitor" type="hidden" value="" />

                    <div class="mb-3">
                        <label for="sexe_visiteur" class="form-label">Sexe :</label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="edit_M" name="sexe_visiteur" value="M" required>
                            <span class="form-check-label">Homme</span>
                        </label>

                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="edit_F" name="sexe_visiteur" value="F" required>
                            <span class="form-check-label">Femme</span>
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="nom_visiteur" class="form-label">Nom :</label>
                        <input type="text" class="form-control" id="edit_nom" name="nom_visiteur" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom_visiteur" class="form-label">Prénom :</label>
                        <input type="text" class="form-control" id="edit_prenom" name="prenom_visiteur" required>
                    </div>
                    <div class="mb-3">
                        <label for="DDN_visiteur" class="form-label">Date de naissance :</label>
                        <input type="date" class="form-control" id="edit_DDN" name="DDN_visiteur">
                    </div>
                    <div class="mb-3">
                        <label for="ville_visiteur" class="form-label">Ville :</label>
                        <input type="text" class="form-control" id="edit_ville" name="ville_visiteur">
                    </div>
                    <div class="mb-3">
                        <label for="tel_visiteur" class="form-label">Téléphone :</label>
                        <input type="text" class="form-control" id="edit_tel" name="tel_visiteur">
                    </div>

                    <div class="mb-3">
                        <label for="ADH_visiteur" class="form-label">Adhérent :</label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="edit_ADH" name="ADH_visiteur" value="1" required>
                            <span class="form-check-label">Oui</span>
                        </label>

                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="edit_nonADH" name="ADH_visiteur" value="0" required>
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
    var data = JSON.parse('<?php echo $jsonData; ?>');

    function openModal(param) {
        var i = JSON.parse(param);
        if (data[i]['sexe'] == "M") {
            document.getElementById("edit_M").checked = true;
        } else {
            document.getElementById("edit_F").checked = true;
        }

        document.getElementById('edit_idVisitor').value = data[i]['id'];
        document.getElementById('edit_nom').value = data[i]['nom'];
        document.getElementById("edit_prenom").value = data[i]['prenom'];
        document.getElementById("edit_DDN").value = data[i]['DDN'];
        document.getElementById("edit_ville").value = data[i]['ville'];
        document.getElementById("edit_tel").value = data[i]['tel'];

        if (data[i]['ADH'] == 1) {
            document.getElementById("edit_ADH").checked = true;
        } else {
            document.getElementById("edit_nonADH").checked = true;
        }

        $('#editVisitor').modal('show');
    }
</script>
<?php
$modals = ob_get_clean();
require 'template/layout.php';
?>