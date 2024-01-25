-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 24 jan. 2024 à 14:58
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+01:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `emargement`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `idActivite` int NOT NULL AUTO_INCREMENT,
  `libelleActivite` varchar(50) NOT NULL,
  `dateDebutActivite` date NOT NULL,
  `dateFinActivite` date NOT NULL,
  PRIMARY KEY (`idActivite`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `activite`
--

INSERT INTO `activite` (`idActivite`, `libelleActivite`, `dateDebutActivite`, `dateFinActivite`) VALUES
(1, 'ESPORT', '2024-01-16', '2025-01-16'),
(2, 'Ludothèque', '2024-01-17', '2025-01-17');

-- --------------------------------------------------------

--
-- Structure de la table `estPresent`
--

DROP TABLE IF EXISTS `estPresent`;
CREATE TABLE IF NOT EXISTS `estPresent` (
  `idPresence` int NOT NULL AUTO_INCREMENT,
  `IDvisiteur` int NOT NULL,
  `idJournee` int NOT NULL,
  `present` tinyint(1) NOT NULL,
  `idActivite` int NOT NULL,
  PRIMARY KEY (`idPresence`),
  KEY `IDvisiteur` (`IDvisiteur`),
  KEY `idJournee` (`idJournee`),
  KEY `idActivite` (`idActivite`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `estPresent`
--

INSERT INTO `estPresent` (`idPresence`, `IDvisiteur`, `idJournee`, `present`, `idActivite`) VALUES
(19, 11, 12, 0, 2),
(20, 11, 12, 0, 1),
(21, 12, 12, 0, 2),
(22, 12, 12, 0, 1),
(23, 13, 12, 0, 2),
(24, 13, 12, 0, 1),
(26, 11, 16, 0, 2),
(27, 11, 16, 1, 1),
(28, 12, 16, 0, 2),
(29, 12, 16, 0, 1),
(30, 13, 16, 0, 2),
(31, 13, 16, 0, 1),
(32, 15, 16, 0, 2),
(33, 15, 16, 0, 1),
(34, 11, 31, 0, 2),
(35, 11, 31, 0, 1),
(36, 12, 31, 0, 2),
(37, 12, 31, 0, 1),
(38, 13, 31, 0, 2),
(39, 13, 31, 1, 1),
(40, 15, 31, 0, 2),
(41, 15, 31, 0, 1),
(42, 11, 32, 0, 2),
(43, 11, 32, 0, 1),
(44, 12, 32, 0, 2),
(45, 12, 32, 0, 1),
(46, 13, 32, 0, 2),
(47, 13, 32, 0, 1),
(48, 15, 32, 0, 2),
(49, 15, 32, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `journée`
--

DROP TABLE IF EXISTS `journée`;
CREATE TABLE IF NOT EXISTS `journée` (
  `idJournee` int NOT NULL AUTO_INCREMENT,
  `dateJournee` date NOT NULL,
  PRIMARY KEY (`idJournee`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `journée`
--

INSERT INTO `journée` (`idJournee`, `dateJournee`) VALUES
(6, '2024-01-13'),
(7, '2024-01-16'),
(12, '2024-01-17'),
(16, '2024-01-18'),
(31, '2024-01-19'),
(32, '2024-01-24');

--
-- Déclencheurs `journée`
--
DROP TRIGGER IF EXISTS `newPresence`;
DELIMITER $$
CREATE TRIGGER `newPresence` AFTER INSERT ON `journée` FOR EACH ROW INSERT INTO estPresent (estPresent.idJournee, estPresent.IDvisiteur, estPresent.idActivite,estPresent.present)
SELECT NEW.idJournee, visiteur.IDvisiteur, activite.idActivite, FALSE
FROM visiteur, activite
WHERE activite.dateDebutActivite <= NEW.dateJournee
AND activite.dateFinActivite >= NEW.dateJournee
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

DROP TABLE IF EXISTS `visiteur`;
CREATE TABLE IF NOT EXISTS `visiteur` (
  `IDvisiteur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `age` int NOT NULL,
  `ville` varchar(50) NOT NULL,
  `ADH` tinyint(1)  DEFAULT '0',
  `tel` varchar(20) DEFAULT NULL,
  `sexe` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`IDvisiteur`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`IDvisiteur`, `nom`, `prenom`, `age`, `ville`, `ADH`, `tel`, `sexe`) VALUES
(11, 'MAALLOU', 'Mehdi', 22, 'Lillebonne', 0, '0766131577', 'M'),
(12, 'LOISON', 'Morgan', 19, 'Rouville', 0, '0649409197', 'M'),
(13, 'LEMAISTRE', 'Mélanie', 21, 'Gravenchon', 0, '0666666666', 'F'),
(15, 'Dupré', 'Jade', 14, 'Bolbec', 0, '061212121212', 'F');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `estPresent`
--
ALTER TABLE `estPresent`
  ADD CONSTRAINT `estPresent_ibfk_1` FOREIGN KEY (`IDvisiteur`) REFERENCES `visiteur` (`IDvisiteur`),
  ADD CONSTRAINT `estPresent_ibfk_2` FOREIGN KEY (`idJournee`) REFERENCES `journée` (`idJournee`),
  ADD CONSTRAINT `estPresent_ibfk_3` FOREIGN KEY (`idActivite`) REFERENCES `activite` (`idActivite`);

DELIMITER $$
--
-- Évènements
--
DROP EVENT IF EXISTS `addDay`$$
CREATE DEFINER=`root`@`localhost` EVENT `addDay` ON SCHEDULE EVERY 1 DAY STARTS '2024-01-17 12:00:00' ON COMPLETION NOT PRESERVE ENABLE DO INSERT INTO journée (dateJournee)
  VALUES (NOW())$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
