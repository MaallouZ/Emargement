document.addEventListener("DOMContentLoaded", function () {
    if ($('#dataTable').length) { // Vérifie que la table existe avant d'initialiser
        $('#dataTable').DataTable({
            "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "Tout"]],
            "pageLength": 100, // Nombre d'entrées par défaut
            "language": {
                "lengthMenu": "Afficher _MENU_ entrées par page",
                "zeroRecords": "Aucune donnée trouvée",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty": "Aucune entrée disponible",
                "infoFiltered": "(filtré sur _MAX_ entrées au total)"
            }
        });
    } else {
        console.error("Tableau #dataTable non trouvé !");
    }
});
