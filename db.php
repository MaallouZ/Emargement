<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=adherents;charset=utf8","root","");
    $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo $ex -> getMessage();
}

?>