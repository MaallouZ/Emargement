-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 22 fév. 2024 à 10:18
-- Version du serveur : 10.5.23-MariaDB-0+deb11u1
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
  `dateFinActivite` date NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `activite`
--

INSERT INTO `activite` (`idActivite`, `libelleActivite`, `dateDebutActivite`, `dateFinActivite`, `enabled`) VALUES
(1, 'ESPORT', '2024-01-16', '2025-01-16', 1),
(2, 'Ludothèque', '2024-01-17', '2025-01-17', 1),
(3, 'test', '2024-02-01', '2024-02-03', 1),
(4, 'test2', '2024-02-01', '2024-02-02', 1);

-- --------------------------------------------------------

--
-- Structure de la table `emprunte`
--

CREATE TABLE `emprunte` (
  `idEmprunt` int(11) NOT NULL,
  `dateEmprunt` date NOT NULL,
  `dateRetourEstime` date NOT NULL,
  `dateRetour` date DEFAULT NULL,
  `idVisiteur` int(11) NOT NULL,
  `idMateriel` int(11) NOT NULL,
  `rendu` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(88, 18, 34, 1, 2),
(90, 11, 35, 0, 1),
(91, 11, 35, 0, 2),
(92, 12, 35, 0, 1),
(93, 12, 35, 0, 2),
(94, 13, 35, 0, 1),
(95, 13, 35, 0, 2),
(96, 15, 35, 0, 1),
(97, 15, 35, 0, 2),
(98, 18, 35, 0, 1),
(99, 18, 35, 0, 2),
(105, 11, 36, 0, 1),
(106, 11, 36, 0, 2),
(107, 12, 36, 0, 1),
(108, 12, 36, 0, 2),
(109, 13, 36, 0, 1),
(110, 13, 36, 0, 2),
(111, 15, 36, 0, 1),
(112, 15, 36, 0, 2),
(113, 18, 36, 0, 1),
(114, 18, 36, 0, 2),
(120, 11, 37, 0, 1),
(121, 11, 37, 0, 2),
(122, 12, 37, 0, 1),
(123, 12, 37, 0, 2),
(124, 13, 37, 0, 1),
(125, 13, 37, 0, 2),
(126, 15, 37, 0, 1),
(127, 15, 37, 0, 2),
(128, 18, 37, 0, 1),
(129, 18, 37, 0, 2),
(135, 11, 38, 0, 1),
(136, 11, 38, 0, 2),
(137, 12, 38, 0, 1),
(138, 12, 38, 0, 2),
(139, 13, 38, 1, 1),
(140, 13, 38, 0, 2),
(141, 15, 38, 1, 1),
(142, 15, 38, 0, 2),
(143, 18, 38, 0, 1),
(144, 18, 38, 0, 2),
(159, 11, 39, 1, 1),
(160, 11, 39, 0, 2),
(161, 12, 39, 1, 1),
(162, 12, 39, 0, 2),
(163, 13, 39, 0, 1),
(164, 13, 39, 0, 2),
(165, 15, 39, 0, 1),
(166, 15, 39, 0, 2),
(167, 18, 39, 0, 1),
(168, 18, 39, 0, 2),
(174, 11, 40, 0, 1),
(175, 11, 40, 0, 2),
(176, 12, 40, 0, 1),
(177, 12, 40, 0, 2),
(178, 13, 40, 0, 1),
(179, 13, 40, 0, 2),
(180, 15, 40, 0, 1),
(181, 15, 40, 0, 2),
(182, 18, 40, 0, 1),
(183, 18, 40, 0, 2),
(189, 11, 41, 0, 1),
(190, 11, 41, 0, 2),
(191, 12, 41, 0, 1),
(192, 12, 41, 0, 2),
(193, 13, 41, 0, 1),
(194, 13, 41, 0, 2),
(195, 15, 41, 0, 1),
(196, 15, 41, 0, 2),
(197, 18, 41, 0, 1),
(198, 18, 41, 0, 2),
(204, 11, 42, 0, 1),
(205, 11, 42, 0, 2),
(206, 12, 42, 0, 1),
(207, 12, 42, 0, 2),
(208, 13, 42, 0, 1),
(209, 13, 42, 0, 2),
(210, 15, 42, 0, 1),
(211, 15, 42, 0, 2),
(212, 18, 42, 0, 1),
(213, 18, 42, 0, 2),
(219, 11, 43, 0, 1),
(220, 11, 43, 0, 2),
(221, 12, 43, 0, 1),
(222, 12, 43, 0, 2),
(223, 13, 43, 0, 1),
(224, 13, 43, 0, 2),
(225, 15, 43, 0, 1),
(226, 15, 43, 0, 2),
(227, 18, 43, 0, 1),
(228, 18, 43, 0, 2),
(234, 11, 44, 1, 1),
(235, 11, 44, 0, 2),
(236, 12, 44, 0, 1),
(237, 12, 44, 0, 2),
(238, 13, 44, 0, 1),
(239, 13, 44, 0, 2),
(240, 15, 44, 0, 1),
(241, 15, 44, 0, 2),
(242, 18, 44, 0, 1),
(243, 18, 44, 0, 2),
(249, 11, 45, 0, 1),
(250, 11, 45, 1, 2),
(251, 12, 45, 0, 1),
(252, 12, 45, 1, 2),
(253, 13, 45, 1, 1),
(254, 13, 45, 0, 2),
(255, 15, 45, 1, 1),
(256, 15, 45, 0, 2),
(257, 18, 45, 0, 1),
(258, 18, 45, 0, 2),
(264, 11, 46, 0, 1),
(265, 11, 46, 0, 2),
(266, 12, 46, 0, 1),
(267, 12, 46, 0, 2),
(268, 13, 46, 0, 1),
(269, 13, 46, 0, 2),
(270, 15, 46, 0, 1),
(271, 15, 46, 0, 2),
(272, 18, 46, 0, 1),
(273, 18, 46, 0, 2),
(279, 11, 47, 0, 1),
(280, 11, 47, 0, 2),
(281, 12, 47, 0, 1),
(282, 12, 47, 0, 2),
(283, 13, 47, 0, 1),
(284, 13, 47, 0, 2),
(285, 15, 47, 0, 1),
(286, 15, 47, 0, 2),
(287, 18, 47, 0, 1),
(288, 18, 47, 0, 2),
(289, 11, 48, 0, 1),
(290, 11, 48, 0, 2),
(291, 12, 48, 0, 1),
(292, 12, 48, 0, 2),
(293, 13, 48, 0, 1),
(294, 13, 48, 0, 2),
(295, 15, 48, 0, 1),
(296, 15, 48, 0, 2),
(297, 18, 48, 0, 1),
(298, 18, 48, 0, 2),
(304, 11, 49, 0, 1),
(305, 11, 49, 0, 2),
(306, 12, 49, 0, 1),
(307, 12, 49, 0, 2),
(308, 13, 49, 0, 1),
(309, 13, 49, 0, 2),
(310, 15, 49, 0, 1),
(311, 15, 49, 0, 2),
(312, 18, 49, 0, 1),
(313, 18, 49, 0, 2),
(319, 11, 50, 0, 1),
(320, 11, 50, 0, 2),
(321, 12, 50, 0, 1),
(322, 12, 50, 0, 2),
(323, 13, 50, 0, 1),
(324, 13, 50, 1, 2),
(325, 15, 50, 0, 1),
(326, 15, 50, 0, 2),
(327, 18, 50, 0, 1),
(328, 18, 50, 1, 2),
(334, 11, 51, 0, 1),
(335, 11, 51, 0, 2),
(336, 12, 51, 0, 1),
(337, 12, 51, 0, 2),
(338, 13, 51, 0, 1),
(339, 13, 51, 0, 2),
(340, 15, 51, 0, 1),
(341, 15, 51, 0, 2),
(342, 18, 51, 0, 1),
(343, 18, 51, 0, 2),
(349, 11, 52, 0, 1),
(350, 11, 52, 0, 2),
(351, 12, 52, 0, 1),
(352, 12, 52, 0, 2),
(353, 13, 52, 0, 1),
(354, 13, 52, 0, 2),
(355, 15, 52, 0, 1),
(356, 15, 52, 0, 2),
(357, 18, 52, 0, 1),
(358, 18, 52, 0, 2),
(364, 11, 53, 0, 1),
(365, 11, 53, 0, 2),
(366, 12, 53, 0, 1),
(367, 12, 53, 0, 2),
(368, 13, 53, 0, 1),
(369, 13, 53, 0, 2),
(370, 15, 53, 0, 1),
(371, 15, 53, 0, 2),
(372, 18, 53, 0, 1),
(373, 18, 53, 0, 2),
(379, 11, 54, 0, 1),
(380, 11, 54, 0, 2),
(381, 12, 54, 0, 1),
(382, 12, 54, 0, 2),
(383, 13, 54, 0, 1),
(384, 13, 54, 0, 2),
(385, 15, 54, 0, 1),
(386, 15, 54, 0, 2),
(387, 18, 54, 0, 1),
(388, 18, 54, 0, 2),
(394, 11, 55, 0, 1),
(395, 11, 55, 0, 2),
(396, 12, 55, 0, 1),
(397, 12, 55, 0, 2),
(398, 13, 55, 0, 1),
(399, 13, 55, 0, 2),
(400, 15, 55, 0, 1),
(401, 15, 55, 0, 2),
(402, 18, 55, 0, 1),
(403, 18, 55, 0, 2),
(409, 11, 56, 0, 1),
(410, 11, 56, 0, 2),
(411, 12, 56, 0, 1),
(412, 12, 56, 0, 2),
(413, 13, 56, 0, 1),
(414, 13, 56, 0, 2),
(415, 15, 56, 0, 1),
(416, 15, 56, 0, 2),
(417, 18, 56, 0, 1),
(418, 18, 56, 0, 2),
(424, 11, 57, 0, 1),
(425, 11, 57, 0, 2),
(426, 12, 57, 1, 1),
(427, 12, 57, 0, 2),
(428, 13, 57, 0, 1),
(429, 13, 57, 0, 2),
(430, 15, 57, 1, 1),
(431, 15, 57, 0, 2),
(432, 18, 57, 1, 1),
(433, 18, 57, 0, 2),
(439, 11, 58, 0, 1),
(440, 11, 58, 0, 2),
(441, 12, 58, 1, 1),
(442, 12, 58, 0, 2),
(443, 13, 58, 0, 1),
(444, 13, 58, 0, 2),
(445, 15, 58, 0, 1),
(446, 15, 58, 0, 2),
(447, 18, 58, 0, 1),
(448, 18, 58, 0, 2);

-- --------------------------------------------------------

--
-- Structure de la table `journée`
--

CREATE TABLE `journée` (
  `idJournee` int(11) NOT NULL,
  `dateJournee` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(34, '2024-01-26'),
(35, '2024-01-27'),
(36, '2024-01-28'),
(37, '2024-01-29'),
(38, '2024-01-30'),
(39, '2024-01-31'),
(40, '2024-02-01'),
(41, '2024-02-04'),
(42, '2024-02-06'),
(43, '2024-02-07'),
(44, '2024-02-08'),
(45, '2024-02-09'),
(46, '2024-02-10'),
(47, '2024-02-11'),
(48, '2024-02-12'),
(49, '2024-02-13'),
(50, '2024-02-14'),
(51, '2024-02-15'),
(52, '2024-02-16'),
(53, '2024-02-17'),
(54, '2024-02-18'),
(55, '2024-02-19'),
(56, '2024-02-20'),
(57, '2024-02-21'),
(58, '2024-02-22');

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
-- Structure de la table `materiel`
--

CREATE TABLE `materiel` (
  `idMateriel` int(11) NOT NULL,
  `libelleMateriel` varchar(50) NOT NULL,
  `referenceMateriel` varchar(16) NOT NULL,
  `etatMateriel` varchar(1000) NOT NULL,
  `estPrete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`idMateriel`, `libelleMateriel`, `referenceMateriel`, `etatMateriel`, `estPrete`) VALUES
(1, 'PC portable', 'MAT0091', '&quot;sucemoilezob&quot;', 0),
(2, 'PC portable', 'MAT0089', '&quot;cefilsdeputeeeeeehhhhhhh&quot;', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`IDvisiteur`, `nom`, `prenom`, `DDN`, `ville`, `ADH`, `tel`, `sexe`) VALUES
(11, 'MAALLOU', 'Mehdi', '2001-08-06', 'LILLEBONNE', 0, '0766131577', 'M'),
(12, 'DUPRE', 'Jade', '2009-11-23', 'BOLBEC', 0, '0645454545', 'F'),
(13, 'LOISON', 'Morgan', '0000-00-00', 'ROUVILLE', 1, '0649409197', 'M'),
(15, 'HAREL', 'Charles', '2003-01-22', 'Yébleron', 1, '06787564568', 'M'),
(18, 'MAALLO', 'Mehd', '0000-00-00', 'Lillebonne', 0, '0766131577', 'M');

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
-- Index pour la table `emprunte`
--
ALTER TABLE `emprunte`
  ADD PRIMARY KEY (`idEmprunt`),
  ADD KEY `idVisiteur` (`idVisiteur`),
  ADD KEY `idMateriel` (`idMateriel`);

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
-- Index pour la table `materiel`
--
ALTER TABLE `materiel`
  ADD PRIMARY KEY (`idMateriel`);

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
  MODIFY `idActivite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `emprunte`
--
ALTER TABLE `emprunte`
  MODIFY `idEmprunt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `estPresent`
--
ALTER TABLE `estPresent`
  MODIFY `idPresence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=454;

--
-- AUTO_INCREMENT pour la table `journée`
--
ALTER TABLE `journée`
  MODIFY `idJournee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `materiel`
--
ALTER TABLE `materiel`
  MODIFY `idMateriel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `visiteur`
--
ALTER TABLE `visiteur`
  MODIFY `IDvisiteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emprunte`
--
ALTER TABLE `emprunte`
  ADD CONSTRAINT `emprunte_ibfk_1` FOREIGN KEY (`idVisiteur`) REFERENCES `visiteur` (`IDvisiteur`),
  ADD CONSTRAINT `emprunte_ibfk_2` FOREIGN KEY (`idMateriel`) REFERENCES `materiel` (`idMateriel`);

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
