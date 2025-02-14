function openModal(param) {

    var data = JSON.parse('<?php echo $jsonData; ?>');
    var act = JSON.parse('<?php echo $jsonAct; ?>');
    document.getElementById('idAct').value = act;
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