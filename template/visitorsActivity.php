<?php
$title = "Visiteurs";
ob_start();
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tableau d'appel</h1>
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
                        <th>Ville</th>
                        <th>Tél</th>
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
                    <input id="idVisitor" name="idVisitor" type="hidden" value="" />
                    <input id="idAct" name="idAct" type="hidden" value="" />

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
                        <input type="text" class="form-control" id="nom_input" name="nom_visiteur" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom_visiteur" class="form-label">Prénom :</label>
                        <input type="text" class="form-control" id="prenom_input" name="prenom_visiteur" required>
                    </div>
                    <div class="mb-3">
                        <label for="DDN_visiteur" class="form-label">Date de naissance :</label>
                        <input type="date" class="form-control" id="DDN_input" name="DDN_visiteur">
                    </div>
                    <div class="mb-3">
                        <label for="ville_visiteur" class="form-label">Ville :</label>
                        <input type="text" class="form-control" id="ville_input" name="ville_visiteur">
                    </div>
                    <div class="mb-3">
                        <label for="tel_visiteur" class="form-label">Téléphone :</label>
                        <input type="text" class="form-control" id="tel_input" name="tel_visiteur">
                    </div>

                    <div class="mb-3">
                        <label for="ADH_visiteur" class="form-label">Adhérent :</label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="ADH_radio" name="ADH_visiteur" value="1" required>
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
    var data = JSON.parse('<?php echo $jsonData; ?>');
    var act = JSON.parse('<?php echo $jsonAct; ?>');
    document.getElementById('idAct').value = act;

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
        } else {
            document.getElementById("nonADH_radio").checked = true;
        }

        $('#editVisitor').modal('show');
    }
</script>
<?php
$modals = ob_get_clean();
require 'template/layout.php';
?>