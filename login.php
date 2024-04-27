<?php
require('db.php');
include('param.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $mdp = htmlspecialchars($_POST["mdp"]);

    $_SESSION['log'] = null;

    $sql = "SELECT * FROM animateur WHERE emailAnimateur = :email;";

    $stmt = $conn -> prepare($sql);
    $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
    $stmt -> execute();

    $result = $stmt -> fetch();

    if ($result != null) {
        if (password_verify($mdp, $result["mdpAnimateur"])) {
            $_SESSION ['log'] = true;
            header('Location: https://anim.mjcbolbec.fr/index.php');
        } else {
            $_SESSION ['log'] = false;
            $error_message = "Mot de passe incorrect";
        }
        
    }
    else{
        $_SESSION ['log'] = false;
        $error_message = "Email inconnu";
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

    <title>Connexion</title>

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

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <img src="img/MJC BOLBEC_LOGO V1.png" alt="Logo MJC Bolbec" height="300px">
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenue !</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <input type="hidden" name="method" value="login">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" name="email"
                                                placeholder="Email" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" name="mdp" placeholder="Mot de passe" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Se souvenir de moi</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Connexion</button>
                                    </form>
                                    <?php
                                    if (isset($error_message)) {
                                        echo('<hr>');
                                        echo('<div class="text-center text-danger">'.$error_message.'</div>');
                                    }
                                    ?>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Créer un compte</a>
                                    </div>
                                </div>
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