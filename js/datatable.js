document.addEventListener("DOMContentLoaded", function () {
    const table = $('#dataTable');
    if (!table.length) {
        console.error("Tableau #dataTable non trouvé !");
        return;
    }

    table.DataTable({
        autoWidth: false,
        pageLength: 100,
        lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "Tout"]],
        columnDefs: [{ width: "280px", targets: 0 }],
        order: [[0, 'desc']],
        language: {
            lengthMenu: "Afficher _MENU_ entrées par page",
            zeroRecords: "Aucune donnée trouvée",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            infoEmpty: "Aucune entrée disponible",
            infoFiltered: "(filtré sur _MAX_ entrées au total)"
        }
    });
});
