ALTER TABLE `user` 
CHANGE `idUser` `id` INT(11) NOT NULL AUTO_INCREMENT,
CHANGE `nomUser` `nom` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
CHANGE `prenomUser` `prenom` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
CHANGE`emailUser` `email` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
CHANGE`mdpUser` `mdp` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
ADD `perm` INT NOT NULL DEFAULT '1' AFTER `mdp`;

ALTER TABLE `activite`
CHANGE `idActivite` `id` INT(11) NOT NULL AUTO_INCREMENT,
CHANGE `libelleActivite` `libelle` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
CHANGE `dateDebutActivite` `dateDebut` DATE NOT NULL, 
CHANGE `dateFinActivite` `dateFin` DATE NOT NULL;

ALTER TABLE `emprunte`
CHANGE `idEmprunt` `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `visiteur` 
CHANGE `IDvisiteur` `ID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `estPresent`
CHANGE `IDvisiteur` `idVisiteur` INT(11) NOT NULL;

ALTER TABLE `visiteur`
CHANGE `ID` `id` INT(11) NOT NULL AUTO_INCREMENT;

-- Evènement de suppression des vielles présences inutiles
CREATE EVENT `delete_old_presence` 
ON SCHEDULE EVERY 7 DAY 
STARTS '2025-03-15 01:00:00.000000' 
ON COMPLETION NOT PRESERVE
ENABLE 
DO 
DELETE FROM estPresent 
WHERE estPresent.present = 0 
AND estPresent.date < (CURRENT_DATE - INTERVAL 30 DAY);