-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mar. 17 déc. 2019 à 09:57
-- Version du serveur :  5.5.64-MariaDB
-- Version de PHP :  7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mendezpo1u`
--

-- --------------------------------------------------------

--
-- Structure de la table `Account`
--

CREATE TABLE `Account` (
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `Account`
--

INSERT INTO `Account` (`login`, `password`) VALUES
('tom', '$2y$12$WAkZ7u7Hb9KY65EvH8DjmewJZOpMfkCdlM9q/a9uJbEZMDZ6yxmy6');

-- --------------------------------------------------------

--
-- Structure de la table `aEcrit`
--

CREATE TABLE `aEcrit` (
  `numAuteur` int(4) NOT NULL DEFAULT '0',
  `ISBN` varchar(13) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `aEcrit`
--

INSERT INTO `aEcrit` (`numAuteur`, `ISBN`) VALUES
(1, '1234567899510'),
(1, '9782070518425'),
(2, '4785469871222'),
(2, '5874698742153'),
(2, '7847589657413'),
(3, '1234567899510'),
(3, '9782070518425');

-- --------------------------------------------------------

--
-- Structure de la table `Auteur`
--

CREATE TABLE `Auteur` (
  `numAuteur` int(4) NOT NULL,
  `nomAuteur` varchar(30) DEFAULT NULL,
  `prenomAuteur` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Auteur`
--

INSERT INTO `Auteur` (`numAuteur`, `nomAuteur`, `prenomAuteur`) VALUES
(1, 'Hugo', 'Victor'),
(2, 'Pennerat', 'Theo'),
(3, 'Racine', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Avis`
--

CREATE TABLE `Avis` (
  `numAvis` int(4) NOT NULL,
  `ISBNAvis` varchar(13) DEFAULT NULL,
  `ISBNConseil` varchar(13) DEFAULT NULL,
  `contenu` varchar(1000) DEFAULT NULL,
  `note` int(3) DEFAULT NULL,
  `numAvisRepondu` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Avis`
--

INSERT INTO `Avis` (`numAvis`, `ISBNAvis`, `ISBNConseil`, `contenu`, `note`, `numAvisRepondu`) VALUES
(1, '9782070518425', NULL, 'Très bon livre, véritable critique de la condition humaine, je recommande fortement.', 90, NULL),
(2, '9782070518425', NULL, NULL, 45, 1),
(3, '9782070518425', NULL, NULL, NULL, 2),
(4, '4785469871222', '7847589657413', NULL, 50, NULL),
(5, '1234567899510', NULL, NULL, 50, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Compte`
--

CREATE TABLE `Compte` (
  `identifiant` int(4) NOT NULL,
  `mail` varchar(30) DEFAULT NULL,
  `mdp` varchar(128) DEFAULT NULL,
  `ISBNDeProfil` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Compte`
--

INSERT INTO `Compte` (`identifiant`, `mail`, `mdp`, `ISBNDeProfil`) VALUES
(2, 'theo.pennerat@gmail.com', 'azerty', '9782070518425'),
(3, 'tom.mendez@gmail.com', '101zz9r14g', '5874698742153'),
(4, 'mike.english@hotmail.uk', 'lovethequeen', '7847589657413'),
(5, 'esteban.iglesias@gmail.com', 'barcelone', '4785469871222');

-- --------------------------------------------------------

--
-- Structure de la table `contient`
--

CREATE TABLE `contient` (
  `numListe` int(4) NOT NULL DEFAULT '0',
  `ISBN` varchar(13) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contient`
--

INSERT INTO `contient` (`numListe`, `ISBN`) VALUES
(2, '5874698742153'),
(2, '9782070518425'),
(3, '4785469871222'),
(3, '7847589657413'),
(4, '1234567899510'),
(4, '9782070518425'),
(5, '5874698742153'),
(5, '7847589657413'),
(6, '1234567899510'),
(6, '4785469871222'),
(7, '5874698742153'),
(7, '9782070518425');

-- --------------------------------------------------------

--
-- Structure de la table `Item`
--

CREATE TABLE `Item` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `descr` text,
  `img` text,
  `url` text,
  `tarif` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Item`
--

INSERT INTO `Item` (`id`, `nom`, `descr`, `img`, `url`, `tarif`) VALUES
(1, 'Champagne', 'Bouteille de champagne + flutes + jeux à gratter', 'champagne.jpg', '', '20.00'),
(2, 'Musique', 'Partitions de piano à 4 mains', 'musique.jpg', '', '25.00'),
(3, 'Exposition', 'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel', 'poirelregarder.jpg', '', '14.00'),
(4, 'Goûter', 'Goûter au FIFNL', 'gouter.jpg', '', '20.00'),
(5, 'Projection', 'Projection courts-métrages au FIFNL', 'film.jpg', '', '10.00'),
(6, 'Bouquet', 'Bouquet de roses et Mots de Marion Renaud', 'rose.jpg', '', '16.00'),
(7, 'Diner Stanislas', 'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)', 'bonroi.jpg', '', '60.00'),
(8, 'Origami', 'Baguettes magiques en Origami en buvant un thé', 'origami.jpg', '', '12.00'),
(9, 'Livres', 'Livre bricolage avec petits-enfants + Roman', 'bricolage.jpg', '', '24.00'),
(10, 'Diner  Grand Rue ', 'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)', 'grandrue.jpg', '', '59.00'),
(11, 'Visite guidée', 'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas', 'place.jpg', '', '11.00'),
(12, 'Bijoux', 'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil', 'bijoux.jpg', '', '29.00'),
(19, 'Jeu contacts', 'Jeu pour échange de contacts', 'contact.png', '', '5.00'),
(22, 'Concert', 'Un concert à Nancy', 'concert.jpg', '', '17.00'),
(23, 'Appart Hotel', 'Appart’hôtel Coeur de Ville, en plein centre-ville', 'apparthotel.jpg', '', '56.00'),
(24, 'Hôtel d\'Haussonville', 'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas', 'hotel_haussonville_logo.jpg', '', '169.00'),
(25, 'Boite de nuit', 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités', 'boitedenuit.jpg', '', '32.00'),
(26, 'Planètes Laser', 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.', 'laser.jpg', '', '15.00'),
(27, 'Fort Aventure', 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.', 'fort.jpg', '', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `item_liste`
--

CREATE TABLE `item_liste` (
  `item_id` int(11) NOT NULL,
  `liste_no` int(11) NOT NULL,
  `reserve` tinyint(1) DEFAULT '0',
  `loginReserv` varchar(30) DEFAULT 'null'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item_liste`
--

INSERT INTO `item_liste` (`item_id`, `liste_no`, `reserve`, `loginReserv`) VALUES
(1, 2, 0, 'null'),
(2, 2, 0, 'null'),
(3, 2, 0, 'null'),
(4, 3, 0, 'null'),
(5, 3, 0, 'null'),
(6, 2, 0, 'null'),
(7, 2, 0, 'null'),
(8, 3, 0, 'null'),
(9, 3, 0, 'null'),
(10, 2, 0, 'null'),
(11, 0, 0, 'null'),
(12, 2, 0, 'null'),
(19, 0, 0, 'null'),
(22, 0, 0, 'null'),
(23, 1, 0, 'null'),
(24, 2, 0, 'null'),
(25, 1, 0, 'null'),
(26, 1, 0, 'null'),
(27, 1, 0, 'null');

-- --------------------------------------------------------

--
-- Structure de la table `List`
--

CREATE TABLE `List` (
  `no` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `expiration` date DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `List`
--

INSERT INTO `List` (`no`, `titre`, `description`, `expiration`, `token`) VALUES
(1, 'Pour fêter le bac !', 'Pour un week-end à Nancy qui nous fera oublier les épreuves. ', '2018-06-27', 'nosecure1'),
(2, 'Liste de mariage d\'Alice et Bob', 'Nous souhaitons passer un week-end royal à Nancy pour notre lune de miel :)', '2018-06-30', 'nosecure2'),
(3, 'C\'est l\'anniversaire de Charlie', 'Pour lui préparer une fête dont il se souviendra :)', '2017-12-12', 'nosecure3'),
(4, 'f', 'e', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Liste`
--

CREATE TABLE `Liste` (
  `numListe` int(4) NOT NULL,
  `nomListe` varchar(30) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `identifiant` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Liste`
--

INSERT INTO `Liste` (`numListe`, `nomListe`, `description`, `identifiant`) VALUES
(2, 'ma liste 1', 'pas de description', 5),
(3, 'pour la plage', 'pas de description', 5),
(4, 'travail', 'pas de description', 2),
(5, 'a lire', 'pas de description', 2),
(6, 'coup de coeur', 'pas de description', 2),
(7, 'mes lectures', 'pas de description', 3),
(8, 'ma liste 1', 'pas de description', 4),
(9, 'ma liste 2', 'pas de description', 4),
(10, 'ma liste 3', 'pas de description', 4),
(11, 'ma liste 4', 'pas de description', 4);

-- --------------------------------------------------------

--
-- Structure de la table `Livre`
--

CREATE TABLE `Livre` (
  `ISBN` varchar(13) NOT NULL DEFAULT '0',
  `titre` varchar(50) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `datePublication` date DEFAULT NULL,
  `editeur` varchar(50) DEFAULT NULL,
  `format` varchar(50) DEFAULT NULL,
  `couverture` varchar(100) DEFAULT NULL,
  `nbPages` int(4) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `score` double(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Livre`
--

INSERT INTO `Livre` (`ISBN`, `titre`, `genre`, `datePublication`, `editeur`, `format`, `couverture`, `nbPages`, `description`, `score`) VALUES
('1234567899510', 'Orgueil et préjugés', 'Long', '1999-10-05', NULL, NULL, NULL, 9999, NULL, 2.01),
('4785469871222', 'Pipin achète une switch', 'Thriller', '1987-01-01', NULL, NULL, NULL, 222, NULL, 57.00),
('5874698742153', 'Pinpin fait du ski', 'SF', '2005-01-01', NULL, NULL, NULL, 745, NULL, 99.99),
('7847589657413', 'Pinpin fait ses courses', 'Lifestyle', '2002-12-14', NULL, NULL, NULL, 50, NULL, 12.50),
('9782070518425', 'Harry Potter à l\'école des sorciers', 'jeunesse', '1997-01-01', NULL, NULL, NULL, 240, NULL, 87.52);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `no` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `possede`
--

CREATE TABLE `possede` (
  `identifiant` int(5) NOT NULL DEFAULT '0',
  `ISBN` varchar(13) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `possede`
--

INSERT INTO `possede` (`identifiant`, `ISBN`) VALUES
(2, '5874698742153'),
(2, '9782070518425'),
(3, '1234567899510'),
(3, '4785469871222'),
(3, '7847589657413'),
(4, '4785469871222'),
(4, '5874698742153'),
(4, '7847589657413'),
(4, '9782070518425'),
(5, '1234567899510');

-- --------------------------------------------------------

--
-- Structure de la table `Pret`
--

CREATE TABLE `Pret` (
  `numPret` int(4) NOT NULL,
  `dateDeb` date DEFAULT NULL,
  `dateARendre` date DEFAULT NULL,
  `dateRendu` date DEFAULT NULL,
  `idPreteur` int(5) DEFAULT NULL,
  `idEmprunteur` int(5) DEFAULT NULL,
  `ISBN` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Pret`
--

INSERT INTO `Pret` (`numPret`, `dateDeb`, `dateARendre`, `dateRendu`, `idPreteur`, `idEmprunteur`, `ISBN`) VALUES
(6, '2019-12-13', '2020-01-13', NULL, 2, 3, '9782070518425'),
(7, '2019-09-10', '2019-10-10', '2019-09-25', 3, 2, '5874698742153'),
(8, '2000-01-01', NULL, '2019-01-01', 3, 4, '7847589657413'),
(9, '2019-12-13', NULL, NULL, 4, 5, '4785469871222'),
(10, '2019-02-03', NULL, NULL, 5, 3, '1234567899510');

-- --------------------------------------------------------

--
-- Structure de la table `Theme`
--

CREATE TABLE `Theme` (
  `numTheme` int(4) NOT NULL,
  `nomTheme` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Theme`
--

INSERT INTO `Theme` (`numTheme`, `nomTheme`) VALUES
(1, 'Marine'),
(2, 'Mécanique quantique'),
(3, 'Informatique appliqué'),
(4, 'Ski nautique');

-- --------------------------------------------------------

--
-- Structure de la table `ThemeListe`
--

CREATE TABLE `ThemeListe` (
  `numTheme` int(4) NOT NULL DEFAULT '0',
  `numListe` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ThemeLivre`
--

CREATE TABLE `ThemeLivre` (
  `numTheme` int(4) NOT NULL DEFAULT '0',
  `ISBN` varchar(13) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ThemeLivre`
--

INSERT INTO `ThemeLivre` (`numTheme`, `ISBN`) VALUES
(1, '9782070518425'),
(2, '5874698742153'),
(2, '9782070518425'),
(3, '5874698742153'),
(3, '7847589657413'),
(4, '7847589657413');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`login`);

--
-- Index pour la table `aEcrit`
--
ALTER TABLE `aEcrit`
  ADD PRIMARY KEY (`numAuteur`,`ISBN`),
  ADD KEY `fk_ISBN_aecrit` (`ISBN`);

--
-- Index pour la table `Auteur`
--
ALTER TABLE `Auteur`
  ADD PRIMARY KEY (`numAuteur`);

--
-- Index pour la table `Avis`
--
ALTER TABLE `Avis`
  ADD PRIMARY KEY (`numAvis`),
  ADD KEY `numAvisRepondu` (`numAvisRepondu`),
  ADD KEY `ISBNAvis` (`ISBNAvis`),
  ADD KEY `ISBNConseil` (`ISBNConseil`);

--
-- Index pour la table `Compte`
--
ALTER TABLE `Compte`
  ADD PRIMARY KEY (`identifiant`),
  ADD KEY `ISBNDeProfil` (`ISBNDeProfil`);

--
-- Index pour la table `contient`
--
ALTER TABLE `contient`
  ADD PRIMARY KEY (`numListe`,`ISBN`),
  ADD KEY `fk_ISBN_contient` (`ISBN`);

--
-- Index pour la table `Item`
--
ALTER TABLE `Item`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `List`
--
ALTER TABLE `List`
  ADD PRIMARY KEY (`no`);

--
-- Index pour la table `Liste`
--
ALTER TABLE `Liste`
  ADD PRIMARY KEY (`numListe`),
  ADD KEY `identifiant` (`identifiant`);

--
-- Index pour la table `Livre`
--
ALTER TABLE `Livre`
  ADD PRIMARY KEY (`ISBN`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`,`no`,`login`),
  ADD KEY `FK_no_Liste` (`no`),
  ADD KEY `FK_login_Compte` (`login`);

--
-- Index pour la table `possede`
--
ALTER TABLE `possede`
  ADD PRIMARY KEY (`identifiant`,`ISBN`),
  ADD KEY `fk_ISBN_possede` (`ISBN`);

--
-- Index pour la table `Pret`
--
ALTER TABLE `Pret`
  ADD PRIMARY KEY (`numPret`),
  ADD KEY `idPreteur` (`idPreteur`),
  ADD KEY `idEmprunteur` (`idEmprunteur`),
  ADD KEY `ISBN` (`ISBN`);

--
-- Index pour la table `Theme`
--
ALTER TABLE `Theme`
  ADD PRIMARY KEY (`numTheme`);

--
-- Index pour la table `ThemeListe`
--
ALTER TABLE `ThemeListe`
  ADD PRIMARY KEY (`numTheme`,`numListe`),
  ADD KEY `fk_Liste_ThemeListe` (`numListe`);

--
-- Index pour la table `ThemeLivre`
--
ALTER TABLE `ThemeLivre`
  ADD PRIMARY KEY (`numTheme`,`ISBN`),
  ADD KEY `fk_ISBN_ThemeLivre` (`ISBN`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Auteur`
--
ALTER TABLE `Auteur`
  MODIFY `numAuteur` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Avis`
--
ALTER TABLE `Avis`
  MODIFY `numAvis` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Compte`
--
ALTER TABLE `Compte`
  MODIFY `identifiant` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Item`
--
ALTER TABLE `Item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `List`
--
ALTER TABLE `List`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Liste`
--
ALTER TABLE `Liste`
  MODIFY `numListe` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `Pret`
--
ALTER TABLE `Pret`
  MODIFY `numPret` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Theme`
--
ALTER TABLE `Theme`
  MODIFY `numTheme` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `aEcrit`
--
ALTER TABLE `aEcrit`
  ADD CONSTRAINT `fk_auteur_aecrit` FOREIGN KEY (`numAuteur`) REFERENCES `Auteur` (`numAuteur`),
  ADD CONSTRAINT `fk_ISBN_aecrit` FOREIGN KEY (`ISBN`) REFERENCES `Livre` (`ISBN`);

--
-- Contraintes pour la table `Avis`
--
ALTER TABLE `Avis`
  ADD CONSTRAINT `Avis_ibfk_1` FOREIGN KEY (`numAvisRepondu`) REFERENCES `Avis` (`numAvis`),
  ADD CONSTRAINT `Avis_ibfk_2` FOREIGN KEY (`ISBNAvis`) REFERENCES `Livre` (`ISBN`),
  ADD CONSTRAINT `Avis_ibfk_3` FOREIGN KEY (`ISBNConseil`) REFERENCES `Livre` (`ISBN`);

--
-- Contraintes pour la table `Compte`
--
ALTER TABLE `Compte`
  ADD CONSTRAINT `Compte_ibfk_1` FOREIGN KEY (`ISBNDeProfil`) REFERENCES `Livre` (`ISBN`);

--
-- Contraintes pour la table `contient`
--
ALTER TABLE `contient`
  ADD CONSTRAINT `fk_ISBN_contient` FOREIGN KEY (`ISBN`) REFERENCES `Livre` (`ISBN`),
  ADD CONSTRAINT `fk_numListe_contient` FOREIGN KEY (`numListe`) REFERENCES `Liste` (`numListe`);

--
-- Contraintes pour la table `Liste`
--
ALTER TABLE `Liste`
  ADD CONSTRAINT `Liste_ibfk_1` FOREIGN KEY (`identifiant`) REFERENCES `Compte` (`identifiant`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_id_Item` FOREIGN KEY (`id`) REFERENCES `Item` (`id`),
  ADD CONSTRAINT `FK_login_Compte` FOREIGN KEY (`login`) REFERENCES `Account` (`login`),
  ADD CONSTRAINT `FK_no_Liste` FOREIGN KEY (`no`) REFERENCES `List` (`no`);

--
-- Contraintes pour la table `possede`
--
ALTER TABLE `possede`
  ADD CONSTRAINT `fk_id_possede` FOREIGN KEY (`identifiant`) REFERENCES `Compte` (`identifiant`),
  ADD CONSTRAINT `fk_ISBN_possede` FOREIGN KEY (`ISBN`) REFERENCES `Livre` (`ISBN`);

--
-- Contraintes pour la table `Pret`
--
ALTER TABLE `Pret`
  ADD CONSTRAINT `Pret_ibfk_1` FOREIGN KEY (`idPreteur`) REFERENCES `Compte` (`identifiant`),
  ADD CONSTRAINT `Pret_ibfk_2` FOREIGN KEY (`idEmprunteur`) REFERENCES `Compte` (`identifiant`),
  ADD CONSTRAINT `Pret_ibfk_3` FOREIGN KEY (`ISBN`) REFERENCES `Livre` (`ISBN`);

--
-- Contraintes pour la table `ThemeListe`
--
ALTER TABLE `ThemeListe`
  ADD CONSTRAINT `fk_Liste_ThemeListe` FOREIGN KEY (`numListe`) REFERENCES `Liste` (`numListe`),
  ADD CONSTRAINT `fk_Theme_ThemeListe` FOREIGN KEY (`numTheme`) REFERENCES `Theme` (`numTheme`);

--
-- Contraintes pour la table `ThemeLivre`
--
ALTER TABLE `ThemeLivre`
  ADD CONSTRAINT `fk_ISBN_ThemeLivre` FOREIGN KEY (`ISBN`) REFERENCES `Livre` (`ISBN`),
  ADD CONSTRAINT `fk_Theme_ThemeLivre` FOREIGN KEY (`numTheme`) REFERENCES `Theme` (`numTheme`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
