<?php
$title = "Erreur 404";
ob_start();
?>

<div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Page introuvable</p>
    <p class="text-gray-500 mb-0">Apparemment vous avez trouvé un bug dans la matrice :D</p>
    <a href="index.php?action=homepage">&larr; Retoure à l'écran d'acceuil</a>
</div>

<?php
$content = ob_get_clean();
require 'template/layout.php';
?>