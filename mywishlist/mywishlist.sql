-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  Dim 22 déc. 2019 à 13:09
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
-- Base de données :  `michel412u`
--

-- --------------------------------------------------------

--
-- Structure de la table `Account`
--

CREATE TABLE `Account` (
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `droit` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `Account`
--

INSERT INTO `Account` (`login`, `password`, `droit`) VALUES
('tom', '$2y$12$WAkZ7u7Hb9KY65EvH8DjmewJZOpMfkCdlM9q/a9uJbEZMDZ6yxmy6', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Item`
--

CREATE TABLE `Item` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `descr` text,
  `img` text,
  `tarif` decimal(5,2) DEFAULT NULL,
  `etatCagnotte` tinyint(1) NOT NULL,
  `valCagnotte` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Item`
--

INSERT INTO `Item` (`id`, `nom`, `descr`, `img`, `tarif`, `etatCagnotte`, `valCagnotte`) VALUES
(1, 'Champagne', 'Bouteille de champagne + flutes + jeux à gratter', 'champagne.jpg', '20.00', 0, '0.00'),
(2, 'Musique', 'Partitions de piano à 4 mains', 'musique.jpg', '25.00', 0, '0.00'),
(3, 'Exposition', 'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel', 'poirelregarder.jpg', '14.00', 0, '0.00'),
(4, 'Goûter', 'Goûter au FIFNL', 'gouter.jpg', '20.00', 0, '0.00'),
(5, 'Projection', 'Projection courts-métrages au FIFNL', 'film.jpg', '10.00', 0, '0.00'),
(6, 'Bouquet', 'Bouquet de roses et Mots de Marion Renaud', 'rose.jpg', '16.00', 0, '0.00'),
(7, 'Diner Stanislas', 'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)', 'bonroi.jpg', '60.00', 0, '0.00'),
(8, 'Origami', 'Baguettes magiques en Origami en buvant un thé', 'origami.jpg', '12.00', 0, '0.00'),
(9, 'Livres', 'Livre bricolage avec petits-enfants + Roman', 'bricolage.jpg', '24.00', 0, '0.00'),
(10, 'Diner  Grand Rue ', 'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)', 'grandrue.jpg', '59.00', 0, '0.00'),
(11, 'Visite guidée', 'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas', 'place.jpg', '11.00', 0, '0.00'),
(12, 'Bijoux', 'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil', 'bijoux.jpg', '29.00', 0, '0.00'),
(19, 'Jeu contacts', 'Jeu pour échange de contacts', 'contact.png', '5.00', 0, '0.00'),
(22, 'Concert', 'Un concert à Nancy', 'concert.jpg', '17.00', 0, '0.00'),
(23, 'Appart Hotel', 'Appart’hôtel Coeur de Ville, en plein centre-ville', 'apparthotel.jpg', '56.00', 0, '0.00'),
(24, 'Hôtel d\'Haussonville', 'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas', 'hotel_haussonville_logo.jpg', '169.00', 0, '0.00'),
(25, 'Boite de nuit', 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités', 'boitedenuit.jpg', '32.00', 0, '0.00'),
(26, 'Planètes Laser', 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.', 'laser.jpg', '15.00', 0, '0.00'),
(27, 'Fort Aventure', 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.', 'fort.jpg', '25.00', 0, '0.00');

-- --------------------------------------------------------

--
-- Structure de la table `item_liste`
--

CREATE TABLE `item_liste` (
  `item_id` int(11) NOT NULL,
  `liste_no` int(11) NOT NULL,
  `reserve` tinyint(1) DEFAULT '0',
  `loginReserv` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'null'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `item_liste`
--

INSERT INTO `item_liste` (`item_id`, `liste_no`, `reserve`, `loginReserv`) VALUES
(1, 3, 0, NULL),
(2, 3, 0, NULL),
(3, 3, 0, NULL),
(4, 4, 0, NULL),
(5, 4, 0, NULL),
(6, 3, 0, NULL),
(7, 3, 0, NULL),
(8, 4, 0, NULL),
(9, 4, 0, NULL),
(10, 3, 0, NULL),
(11, 1, 0, NULL),
(12, 3, 0, NULL),
(19, 1, 0, NULL),
(22, 1, 0, NULL),
(23, 2, 0, NULL),
(24, 3, 0, NULL),
(25, 2, 0, NULL),
(26, 2, 0, NULL),
(27, 2, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `List`
--

CREATE TABLE `List` (
  `no` int(11) NOT NULL,
  `createur` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `expiration` date DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publique` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `List`
--

INSERT INTO `List` (`no`, `createur`, `titre`, `description`, `expiration`, `token`, `publique`) VALUES
(1, 'tom', 'Pour fêter le bac !', 'Pour un week-end à Nancy qui nous fera oublier les épreuves. ', '2018-06-27', 'nosecure1', 0),
(2, 'tom', 'Liste de mariage d\'Alice et Bob', 'Nous souhaitons passer un week-end royal à Nancy pour notre lune de miel :)', '2018-06-30', 'nosecure2', 0),
(3, 'tom', 'C\'est l\'anniversaire de Charlie', 'Pour lui préparer une fête dont il se souviendra :)', '2017-12-12', 'nosecure3', 0),
(4, 'tom', 'f', 'e', NULL, '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `idMessage` int(11) NOT NULL,
  `no` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`idMessage`, `no`, `login`, `message`) VALUES
(1, 1, 'tom', 'Merci d\'acheter tout ce que je veux les esclaves !');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`login`);

--
-- Index pour la table `Item`
--
ALTER TABLE `Item`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `item_liste`
--
ALTER TABLE `item_liste`
  ADD PRIMARY KEY (`item_id`,`liste_no`),
  ADD KEY `FK_loginReserv_account` (`loginReserv`),
  ADD KEY `FK_listNo_liste` (`liste_no`);

--
-- Index pour la table `List`
--
ALTER TABLE `List`
  ADD PRIMARY KEY (`no`),
  ADD KEY `FK_createur_account` (`createur`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`idMessage`),
  ADD KEY `FK_no_Liste` (`no`),
  ADD KEY `FK_login_Compte` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

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
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `item_liste`
--
ALTER TABLE `item_liste`
  ADD CONSTRAINT `FK_itemId_item` FOREIGN KEY (`item_id`) REFERENCES `Item` (`id`),
  ADD CONSTRAINT `FK_listNo_liste` FOREIGN KEY (`liste_no`) REFERENCES `List` (`no`),
  ADD CONSTRAINT `FK_loginReserv_account` FOREIGN KEY (`loginReserv`) REFERENCES `Account` (`login`);

--
-- Contraintes pour la table `List`
--
ALTER TABLE `List`
  ADD CONSTRAINT `FK_createur_account` FOREIGN KEY (`createur`) REFERENCES `Account` (`login`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_login_Compte` FOREIGN KEY (`login`) REFERENCES `Account` (`login`),
  ADD CONSTRAINT `FK_no_Liste` FOREIGN KEY (`no`) REFERENCES `List` (`no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
