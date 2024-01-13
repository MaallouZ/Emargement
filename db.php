<?php
include('param.php');

try {
    $conn = new PDO("mysql:host=".$host.";dbname=".$db.";charset=utf8",$user,$pwd);
    $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Erreur: " . $ex -> getMessage());
}

?>