# Emargement – Application web métier de gestion des présences

## Présentation

Emargement est une application web métier développée dans le cadre de mon alternance à la MJC Jacques Prévert de Bolbec.

L’objectif du projet était de remplacer un fonctionnement manuel / tableur par une application web permettant de centraliser la gestion des visiteurs, des activités, des présences, des statistiques et des exports de données.

Le projet a été conçu, développé et déployé en production dans un contexte réel, avec prise en compte des retours utilisateurs et des besoins métier de la structure.

## Fonctionnalités principales

* Gestion des visiteurs
* Gestion des activités
* Suivi des présences par jour et par activité
* Authentification des utilisateurs
* Gestion des permissions
* Tableaux de bord statistiques
* Exports de données
* Interface responsive
* Déploiement sur serveur Linux Debian avec stack LAMP

## Stack technique

* PHP
* Architecture MVC
* MySQL / MariaDB
* JavaScript
* HTML5 / CSS3
* Bootstrap
* Chart.js
* DataTables
* Linux Debian
* Apache
* phpMyAdmin

## Contexte technique

L’application repose sur une architecture MVC côté serveur.

Structure générale du projet :

```text
/src
  /controller
  /model
  /lib

/template
  vues de l’application

/public
  ressources publiques

/js
  scripts JavaScript

/data
  données nécessaires à certaines fonctionnalités
```

La base de données permet de gérer les visiteurs, les activités, les présences, les utilisateurs et les droits d’accès.

## Ce que j’ai réalisé

Sur ce projet, j’ai travaillé sur :

* la conception de la base de données ;
* le développement de l’application en PHP MVC ;
* la mise en place de l’authentification ;
* la gestion des permissions utilisateurs ;
* le développement des statistiques ;
* l’export des données ;
* le déploiement sur serveur Debian ;
* la correction de bugs en conditions réelles ;
* l’intégration des retours utilisateurs ;
* la prise en compte de sujets RGPD.

## Captures d’écran

Des captures d’écran de l’application sont disponibles dans le dossier :

```text
/docs/screenshots
```

## Installation locale

### Prérequis

* PHP 7.4 ou supérieur
* MySQL / MariaDB
* Apache ou environnement local type WAMP/XAMPP
* Composer si nécessaire selon les dépendances utilisées

### Étapes

1. Cloner le projet :

```bash
git clone https://github.com/MaallouZ/Emargement.git
```

2. Placer le projet dans le dossier web de votre environnement local.

3. Créer une base de données MySQL.

4. Importer le fichier SQL fourni dans le dossier `/database` si disponible.

5. Configurer la connexion à la base de données dans le fichier de configuration prévu à cet effet.

6. Lancer l’application depuis le navigateur.

## Remarque

Ce dépôt a été nettoyé afin de ne pas exposer de données sensibles, de données personnelles ou d’identifiants utilisés en production.

Certaines informations liées à l’environnement réel de déploiement ont été retirées ou anonymisées.

## Compétences mises en œuvre

* Développement backend PHP
* Architecture MVC
* Modélisation SQL
* Développement front-end
* Authentification et permissions
* Statistiques et visualisation de données
* Déploiement Linux
* Gestion des retours utilisateurs
* Maintenance applicative
* Sensibilisation aux enjeux RGPD
