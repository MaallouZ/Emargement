<?php
session_start();
session_destroy();
header("Location: http://localhost/GitHub/emargement/login.php");
exit;
?>