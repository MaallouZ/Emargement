<?php
require 'src/model/user.php';
require 'src/model/login.php';
require_once 'src/lib/Database.php';

function login() {
    $error_message = null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        $pwd = $_POST["pwd"] ?? '';

        if (!$email || !$pwd) {
            $error_message = "Veuillez remplir tous les champs.";
        } else {
            $db = Database::getInstance();
            $user = authenticate($email, $pwd, $db);

            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['log'] = true;
                header("Location: index.php?action=homepage");
                exit();
            } else {
                $error_message = "Email ou mot de passe incorrect.";
            }
        }
    }

    require 'template/login.php';
}