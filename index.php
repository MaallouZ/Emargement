<?php
require("db.php");

$stmt = $conn -> prepare("SELECT * FROM journée;");
$stmt -> execute();
$tabJournée = $stmt -> fetchAll();

$stmt = $conn -> prepare("SELECT * FROM visiteur;");
$stmt -> execute();
$tabVisiteur = $stmt -> fetchAll();

?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Emargement</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>
    <header>

    </header>

    <body>
            <h1>TG</h1>
        
    </body>
</html>