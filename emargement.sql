-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 13 jan. 2024 à 14:59
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
  PRIMARY KEY (`idActivite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `estpresent`
--

DROP TABLE IF EXISTS `estpresent`;
CREATE TABLE IF NOT EXISTS `estpresent` (
  `idPresence` int NOT NULL AUTO_INCREMENT,
  `IDvisiteur` int DEFAULT NULL,
  `idJournee` int DEFAULT NULL,
  `present` tinyint(1) DEFAULT NULL,
  `idActivite` int DEFAULT NULL,
  PRIMARY KEY (`idPresence`),
  KEY `IDvisiteur` (`IDvisiteur`),
  KEY `idJournee` (`idJournee`),
  KEY `idActivite` (`idActivite`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `journée`
--

DROP TABLE IF EXISTS `journée`;
CREATE TABLE IF NOT EXISTS `journée` (
  `idJournee` int NOT NULL AUTO_INCREMENT,
  `dateJournee` date NOT NULL,
  PRIMARY KEY (`idJournee`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déclencheurs `journée`
--
DROP TRIGGER IF EXISTS `newPresence`;
DELIMITER $$
CREATE TRIGGER `newPresence` AFTER INSERT ON `journée` FOR EACH ROW INSERT INTO estpresent (IDvisiteur, idJournee, Present)
SELECT visiteur.ID, NEW.idJournee, FALSE
FROM visiteur
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
  `ADH` tinyint(1) NOT NULL DEFAULT '0',
  `tel` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`IDvisiteur`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`IDvisiteur`, `nom`, `prenom`, `age`, `ville`, `ADH`, `tel`) VALUES
(11, 'MAALLOU', 'Mehdi', 22, 'Lillebonne', 0, NULL),
(12, 'LOISON', 'Morgan', 19, 'Rouville', 0, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `estpresent`
--
ALTER TABLE `estpresent`
  ADD CONSTRAINT `estpresent_ibfk_1` FOREIGN KEY (`IDvisiteur`) REFERENCES `visiteur` (`IDvisiteur`),
  ADD CONSTRAINT `estpresent_ibfk_2` FOREIGN KEY (`idJournee`) REFERENCES `journée` (`idJournee`),
  ADD CONSTRAINT `estpresent_ibfk_3` FOREIGN KEY (`idActivite`) REFERENCES `activite` (`idActivite`);

DELIMITER $$
--
-- Évènements
--
DROP EVENT IF EXISTS `addDay`$$
CREATE DEFINER=`root`@`localhost` EVENT `addDay` ON SCHEDULE EVERY 1 DAY STARTS '2024-01-11 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO INSERT INTO journée (dateJournee)
VALUES(NOW())$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
