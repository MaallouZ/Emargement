<?php
require('db.php');
include('param.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nomUser"]);
    $prenom = htmlspecialchars($_POST["prenomUser"]);
    $email = htmlspecialchars($_POST["emailUser"]);
    $mdp = htmlspecialchars($_POST["mdpUser"]);
    $mdpConf = htmlspecialchars($_POST["mdpConf"]);

    if ($mdp == $mdpConf) {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
            
        $stmt = $conn -> prepare("INSERT INTO utilisateur (nomUser, prenomUser, emailUser, mdpUser) VALUES (:nom, :prenom, :email, :mdp);");
        $stmt ->bindParam(":nom", $nom, PDO::PARAM_STR);
        $stmt ->bindParam(":prenom", $prenom, PDO::PARAM_STR);
        $stmt ->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt ->bindParam(":mdp", $mdp, PDO::PARAM_STR);

        try {
            $stmt->execute();
            header("http://localhost/GitHub/emargement/login.php");
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    } else {
        $error_message = "Veuillez confirmer le mot de passe.";
    }
    
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="template/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <img src="img/MJC BOLBEC_LOGO V1.png" alt="Logo MJC Bolbec" height="300px">
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créer un compte</h1>
                            </div>
                            <form class="user" method="post">
                            <input id="method" name="method" type="hidden" value="register"/>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName" name="nomUser"
                                            placeholder="Nom" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName" name="prenomUser"
                                            placeholder="Prénom" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="emailUser"
                                        placeholder="Email" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" name="mdpUser" placeholder="Mot de passe" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" name="mdpConf" placeholder="Confirmer le mot de passe" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    S'enregistrer
                                </button>
                            </form>
                            <?php
                            if (isset($error_message)) {
                                echo('<hr>');
                                echo('<div class="text-center text-danger">'.$error_message.'</div>');
                            }
                            ?>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login.php">Déjà un compte? Connectez vous!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="template/vendor/jquery/jquery.min.js"></script>
    <script src="template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="template/js/sb-admin-2.min.js"></script>

</body>

</html>