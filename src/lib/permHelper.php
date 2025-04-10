<?php

class permHelper {

    private const perm = [
        "admin" => -2,  //Permission admin
        "getAllStats" => -1,    //Permission de récupérer les stats à retransmettre en fin de chaine d'administration
        "ban" => 0,     //Utilisateur banni
        "login" => 1,   //Permission de se connecter seulement
        "SC.acc.pres" => 2, //Permission pour service civique de gérer les présence à l'accueil
        "acc.view" => 3,    //Permission d'accueil pour voir l'ensemble des données perso des visiteurs
        "acc.add" => 4,     //Permission d'accueil pour enregistrer un nouveau visiteur
        "SC.act.pres" => 5,  //Permission service civique pour enregistrer les visiteur comme présent dans les activités
        "SC.act.histo.view" => 6,   //Permission service civique pour accéder à l'historique des présence des activités
        "act.histo.edit" => 7,  //Permission d'éditer les présences dans l'historique d'une activité
        "act.view" => 8,    //Permission de voir les données personnels des visiteurs ainsi que les stats d'une activité
        "emprunt" => 9      //Permission de gérer les emprunts de matériel.
    ];

    // Return true if user permissions is above parameter
    public static function hasSupPerm(string $requiredLevel): bool {
        return isset($_SESSION['user']) && $_SESSION['user']['perm'] > self::perm[$requiredLevel];
    }

    // return true if user permission is below parameter
    public static function hasInfPerm(string $requiredLevel): bool {
        return isset($_SESSION['user']) && $_SESSION['user']['perm'] < self::perm[$requiredLevel];
    }

    // return true if user permission is between parameters
    public static function hasBetweenPerm(string $infPerm, string $supPerm): bool {
        return isset($_SESSION['user']) && ($_SESSION['user']['perm'] >= self::perm[$infPerm] && $_SESSION['user']['perm'] <= self::perm[$supPerm]);
    }

    // return true if user permission is equal to parameter
    public static function hasEqualPerm(string $requiredLevel): bool {
        return isset($_SESSION['user']) && $_SESSION['user']['perm'] == self::perm[$requiredLevel];
    }

    // return true is user permission id different than parameter
    public static function hasDiffPerm(string $requiredLevel): bool {
        return isset($_SESSION['user']) && $_SESSION['user']['perm'] != self::perm[$requiredLevel];
    }

    public static function getPerm() : array{
        return self::perm ;
    }
}