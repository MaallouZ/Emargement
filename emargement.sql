-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 31 jan. 2024 à 13:51
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

-- --------------------------------------------------------

--
-- Structure de la table `journée`
--

CREATE TABLE `journée` (
  `idJournee` int(11) NOT NULL,
  `dateJournee` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


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
  `DDN` date NOT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `ADH` tinyint(1) DEFAULT 0,
  `tel` varchar(20) DEFAULT NULL,
  `sexe` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  MODIFY `idPresence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT pour la table `journée`
--
ALTER TABLE `journée`
  MODIFY `idJournee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `visiteur`
--
ALTER TABLE `visiteur`
  MODIFY `IDvisiteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
