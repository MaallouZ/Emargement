-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 26 jan. 2024 à 14:31
-- Version du serveur : 10.5.21-MariaDB-0+deb11u1
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


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

CREATE TABLE `activite` (
  `idActivite` int(11) NOT NULL,
  `libelleActivite` varchar(50) NOT NULL,
  `dateDebutActivite` date NOT NULL,
  `dateFinActivite` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE `estPresent` (
  `idPresence` int(11) NOT NULL,
  `IDvisiteur` int(11) NOT NULL,
  `idJournee` int(11) NOT NULL,
  `present` tinyint(1) NOT NULL,
  `idActivite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `estPresent`
--

INSERT INTO `estPresent` (`idPresence`, `IDvisiteur`, `idJournee`, `present`, `idActivite`) VALUES
(19, 11, 12, 1, 2),
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
(49, 15, 32, 0, 1),
(57, 11, 33, 1, 1),
(58, 11, 33, 0, 2),
(59, 12, 33, 1, 1),
(60, 12, 33, 0, 2),
(61, 13, 33, 1, 1),
(62, 13, 33, 0, 2),
(63, 15, 33, 0, 1),
(64, 15, 33, 0, 2),
(72, 11, 34, 1, 1),
(73, 11, 34, 0, 2),
(74, 12, 34, 1, 1),
(75, 12, 34, 0, 2),
(76, 13, 34, 1, 1),
(77, 13, 34, 0, 2),
(78, 15, 34, 1, 1),
(79, 15, 34, 0, 2),
(87, 18, 34, 1, 1),
(88, 18, 34, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `journée`
--

CREATE TABLE `journée` (
  `idJournee` int(11) NOT NULL,
  `dateJournee` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `journée`
--

INSERT INTO `journée` (`idJournee`, `dateJournee`) VALUES
(6, '2024-01-13'),
(7, '2024-01-16'),
(12, '2024-01-17'),
(16, '2024-01-18'),
(31, '2024-01-19'),
(32, '2024-01-24'),
(33, '2024-01-25'),
(34, '2024-01-26');

--
-- Déclencheurs `journée`
--
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

CREATE TABLE `visiteur` (
  `IDvisiteur` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `age` int(11) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `ADH` tinyint(1) DEFAULT 0,
  `tel` varchar(20) DEFAULT NULL,
  `sexe` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`IDvisiteur`, `nom`, `prenom`, `age`, `ville`, `ADH`, `tel`, `sexe`) VALUES
(11, 'MAALLOU', 'Mehdi', 22, 'Lillebonne', 0, '0766131577', 'M'),
(12, 'LOISON', 'Morgan', 19, 'Rouville', 0, '0649409197', 'M'),
(13, 'LEMAISTRE', 'Mélanie', 21, 'Gravenchon', 0, '0666666666', 'F'),
(15, 'Dupré', 'Jade', 14, 'Bolbec', 0, '061212121212', 'F'),
(18, 'MOUSSON', 'Marine', 32, 'LILLEBONNE', 0, '0666666666', 'F');

--
-- Déclencheurs `visiteur`
--
DELIMITER $$
CREATE TRIGGER `trig_insert_visiteur` AFTER INSERT ON `visiteur` FOR EACH ROW INSERT INTO estPresent (idVisiteur, idActivite, present, idJournee)
    SELECT NEW.idVisiteur, activite.idActivite, "0", (
        SELECT idJournee
        FROM journée
        WHERE dateJournee = DATE(NOW())
        ORDER BY dateJournee DESC
        LIMIT 1
    )
    FROM activite
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`idActivite`);

--
-- Index pour la table `estPresent`
--
ALTER TABLE `estPresent`
  ADD PRIMARY KEY (`idPresence`),
  ADD KEY `IDvisiteur` (`IDvisiteur`),
  ADD KEY `idJournee` (`idJournee`),
  ADD KEY `idActivite` (`idActivite`);

--
-- Index pour la table `journée`
--
ALTER TABLE `journée`
  ADD PRIMARY KEY (`idJournee`);

--
-- Index pour la table `visiteur`
--
ALTER TABLE `visiteur`
  ADD PRIMARY KEY (`IDvisiteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activite`
--
ALTER TABLE `activite`
  MODIFY `idActivite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `estPresent`
--
ALTER TABLE `estPresent`
  MODIFY `idPresence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT pour la table `journée`
--
ALTER TABLE `journée`
  MODIFY `idJournee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `visiteur`
--
ALTER TABLE `visiteur`
  MODIFY `IDvisiteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
