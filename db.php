<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=emargement;charset=utf8","root","");
    $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Erreur: " . $ex -> getMessage());
}

?>