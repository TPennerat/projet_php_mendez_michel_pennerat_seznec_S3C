-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 13 jan. 2020 à 21:09
-- Version du serveur :  10.4.8-MariaDB
-- Version de PHP :  7.3.11

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
-- Structure de la table `account`
--

CREATE TABLE `account` (
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `droit` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`login`, `password`, `droit`) VALUES
('admin', '$2y$12$3lBKYzKgqkzOtWE6QlVcquWtD84J7njCehKOL.GTUJFMUE04kvNAC', 0),
('damien', '$2y$12$6eftspvrfAUOD.17b6wn8.yBNjLtMGlfWKRKC956c.qtXnLYf9KuS', 0),
('tom', '$2y$12$WAkZ7u7Hb9KY65EvH8DjmewJZOpMfkCdlM9q/a9uJbEZMDZ6yxmy6', 0);

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `descr` text DEFAULT NULL,
  `img` text DEFAULT NULL,
  `tarif` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `nom`, `descr`, `img`, `tarif`) VALUES
(1, 'Champagne', 'Bouteille de champagne + flutes + jeux à gratter', 'champagne.jpg', '20.00'),
(2, 'Musique', 'Partitions de piano à 4 mains', 'musique.jpg', '25.00'),
(3, 'Exposition', 'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel', 'poirelregarder.jpg', '14.00'),
(4, 'Goûter', 'Goûter au FIFNL', 'gouter.jpg', '20.00'),
(5, 'Projection', 'Projection courts-métrages au FIFNL', 'film.jpg', '10.00'),
(6, 'Bouquet', 'Bouquet de roses et Mots de Marion Renaud', 'rose.jpg', '16.00'),
(7, 'Diner Stanislas', 'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)', 'bonroi.jpg', '60.00'),
(8, 'Origami', 'Baguettes magiques en Origami en buvant un thé', 'origami.jpg', '12.00'),
(9, 'Livres', 'Livre bricolage avec petits-enfants + Roman', 'bricolage.jpg', '24.00'),
(10, 'Diner  Grand Rue ', 'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)', 'grandrue.jpg', '59.00'),
(11, 'Visite guidée', 'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas', 'place.jpg', '11.00'),
(12, 'Bijoux', 'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil', 'bijoux.jpg', '29.00'),
(19, 'Jeu contacts', 'Jeu pour échange de contacts', 'contact.png', '5.00'),
(22, 'Concert', 'Un concert à Nancy', 'concert.jpg', '17.00'),
(23, 'Appart Hotel', 'Appart’hôtel Coeur de Ville, en plein centre-ville', 'apparthotel.jpg', '56.00'),
(24, 'Hôtel d\'Haussonville', 'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas', 'hotel_haussonville_logo.jpg', '169.00'),
(25, 'Boite de nuit', 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités', 'boitedenuit.jpg', '32.00'),
(26, 'Planètes Laser', 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.', 'laser.jpg', '15.00'),
(27, 'Fort Aventure', 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.', 'fort.jpg', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `item_liste`
--

CREATE TABLE `item_liste` (
  `item_id` int(11) NOT NULL,
  `liste_no` int(11) NOT NULL,
  `reserve` tinyint(1) DEFAULT 0,
  `loginReserv` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'null',
  `messageReserve` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `etatCagnotte` tinyint(1) NOT NULL,
  `valCagnotte` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `item_liste`
--

INSERT INTO `item_liste` (`item_id`, `liste_no`, `reserve`, `loginReserv`, `messageReserve`, `etatCagnotte`, `valCagnotte`) VALUES
(1, 3, 0, NULL, NULL, 0, '0.00'),
(2, 3, 0, NULL, NULL, 0, '0.00'),
(3, 3, 0, NULL, NULL, 0, '0.00'),
(6, 3, 0, NULL, NULL, 0, '0.00'),
(7, 3, 0, NULL, NULL, 0, '0.00'),
(10, 3, 0, NULL, NULL, 0, '0.00'),
(11, 1, 0, NULL, NULL, 0, '0.00'),
(12, 3, 0, NULL, NULL, 0, '0.00'),
(19, 1, 0, NULL, NULL, 0, '0.00'),
(22, 1, 0, NULL, NULL, 0, '0.00'),
(22, 18, 0, NULL, NULL, 0, '0.00'),
(23, 2, 0, NULL, NULL, 0, '0.00'),
(24, 3, 0, NULL, NULL, 0, '0.00'),
(25, 2, 0, NULL, NULL, 0, '0.00'),
(26, 2, 0, NULL, NULL, 0, '0.00'),
(27, 2, 0, NULL, NULL, 0, '0.00');

-- --------------------------------------------------------

--
-- Structure de la table `list`
--

CREATE TABLE `list` (
  `no` int(11) NOT NULL,
  `createur` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publique` tinyint(1) NOT NULL DEFAULT 0,
  `tokenPartage` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `list`
--

INSERT INTO `list` (`no`, `createur`, `titre`, `description`, `expiration`, `token`, `publique`, `tokenPartage`) VALUES
(1, 'tom', 'Pour fêter le bac !', 'Pour un week-end à Nancy qui nous fera oublier les épreuves. ', '2018-06-27', 'nosecure1', 0, 'token1'),
(2, 'tom', 'Liste de mariage d\'Alice et Bob', 'Nous souhaitons passer un week-end royal à Nancy pour notre lune de miel :)', '2018-06-30', 'nosecure2', 0, 'token2'),
(3, 'tom', 'C\'est l\'anniversaire de Charlie', 'Pour lui préparer une fête dont il se souviendra :)', '2017-12-12', 'nosecure3', 0, 'token3'),
(16, 'admin', 'testx', 'grgr', NULL, 'f6d6ebe085825d68', 1, 'token4'),
(17, 'admin', 'test', 'test', NULL, 'e0ce1c45b9fde27f', 1, 'token5'),
(18, 'admin', 'fezfez', 'fefz', NULL, '9ef964956f60f8b7', 0, 'token6'),
(19, 'admin', 'testxfbdfbdf', 'gregere', NULL, '094ae5563d1e7199', 0, '484ae5563d1e7199'),
(20, 'admin', 'Liste de noel', 'pour mon cousin', '2045-12-12', '5dac65793fdc4085', 1, '60c4f060cbee21bc'),
(30, 'damien', 'saloperie', 'massarza', '2020-03-19', '0e0a7aad4b25e811', 1, '87228b3e048e6cd8'),
(31, 'damien', 'eeger', 'gregrege', '2020-02-14', '5f252ea53a84d66a', 1, 'cab0598bd3a9ba78'),
(32, 'damien', 'ListeMegaBien', 'ElleEstSuper', '2020-02-20', '1c9c205a73b3d4de', 1, '06be3ab741f2b512');

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
(1, 1, 'tom', 'Merci d\'acheter tout ce que je veux les esclaves !'),
(2, 16, 'admin', 'Salut a tous'),
(3, 16, 'admin', 'Merci pour les kdos');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`login`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `item_liste`
--
ALTER TABLE `item_liste`
  ADD PRIMARY KEY (`item_id`,`liste_no`),
  ADD KEY `FK_listNo_liste` (`liste_no`);

--
-- Index pour la table `list`
--
ALTER TABLE `list`
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
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `list`
--
ALTER TABLE `list`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `item_liste`
--
ALTER TABLE `item_liste`
  ADD CONSTRAINT `FK_itemId_item` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_listNo_liste` FOREIGN KEY (`liste_no`) REFERENCES `list` (`no`),
  ADD CONSTRAINT `FK_loginReserv_account` FOREIGN KEY (`loginReserv`) REFERENCES `account` (`login`);

--
-- Contraintes pour la table `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `FK_createur_account` FOREIGN KEY (`createur`) REFERENCES `account` (`login`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_login_Compte` FOREIGN KEY (`login`) REFERENCES `account` (`login`),
  ADD CONSTRAINT `FK_no_Liste` FOREIGN KEY (`no`) REFERENCES `list` (`no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
