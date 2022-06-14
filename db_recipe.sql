-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 14 juin 2022 à 07:59
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_recipe`
--

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

DROP TABLE IF EXISTS `picture`;
CREATE TABLE IF NOT EXISTS `picture` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`picture_id`),
  UNIQUE KEY `link` (`name`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `picture`
--

INSERT INTO `picture` (`picture_id`, `recipe_id`, `name`) VALUES
(42, 52, '627bda81b56b11.59672033.jpg'),
(43, 54, '627d07d712c450.72197883.jpg'),
(46, 55, '628dd1dcdb6b06.18039500.jpg'),
(47, 56, '627d4a1555dd25.98568935.jpg'),
(48, 57, '628497703f68e2.36097833.jpg'),
(49, 93, '62851271a724a0.04435120.jpg'),
(51, 95, '6286758cc2f492.59435575.jpg'),
(52, 96, '628677af304583.75065246.jpg'),
(81, 125, '628dd0cd72a366.35050298.jpg'),
(82, 126, '628738ba3fa9f2.52644070.jpg'),
(87, 137, '62949a67653b10.30708252.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE IF NOT EXISTS `recipe` (
  `recipe_id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_title` varchar(100) NOT NULL,
  `guest_number` int(11) NOT NULL,
  `setup_time` time NOT NULL,
  `level` varchar(50) NOT NULL,
  `price` varchar(50) NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`recipe_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `recipe`
--

INSERT INTO `recipe` (`recipe_id`, `recipe_title`, `guest_number`, `setup_time`, `level`, `price`, `author_id`) VALUES
(52, 'cannelloni', 4, '00:30:00', 'faible', 'faible', 26),
(54, 'cookies', 8, '00:30:00', 'faible', 'faible', 26),
(55, 'tiramisu', 8, '00:30:00', 'moyen', 'moyen', 1),
(56, 'Porc au caramel', 6, '00:50:00', 'élevé', 'faible', 1),
(57, 'spaghetti carbonara', 4, '00:40:00', 'faible', 'faible', 1),
(93, 'pancakes', 6, '00:40:00', 'faible', 'faible', 1),
(95, 'poulet au curry', 5, '01:00:00', 'moyen', 'moyen', 1),
(96, 'Gateau au chocolat', 1, '00:30:00', 'faible', 'faible', 1),
(125, 'fraisier', 9, '00:30:00', 'moyen', 'moyen', 1),
(126, 'Boeuf Bourgignon', 4, '02:00:00', 'élevé', 'moyen', 28),
(137, 'pizza', 6, '01:00:00', 'moyen', 'faible', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UNIQUE` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `user_email`, `first_name`, `last_name`, `password`) VALUES
(1, 'lancelle.clara@hotmail.com', 'clara', 'lancelle', '1234'),
(2, 'jeff.jacquelot@gmail.com', 'jeff', 'jacquelot', '4567'),
(6, 'langlois.nadine@gmail.com', 'nadine', 'langlois', '4789'),
(9, 'lancelle.dom@gmail.com', 'dom', 'lancelle', '7418'),
(11, 'lanubcs@fhxjs.com', 'lmpghjkl', 'lkmjm', '56123'),
(24, 'lancelle.clara@gmail.com', 'Clara', 'lancelle', '4569'),
(26, 'fghjk@fghjkl.bom', 'clara', 'lancelle', 'dfgh'),
(27, 'test@test.fr', 'test', 'test', 'test'),
(28, 'jacquelotjeff@gmail.com', 'Jeff', 'Martins-Jacquelot', 'Coucou758#'),
(29, 'Lancelle.clara@hotmail.fr', 'Clara', 'Lancelle', '$2y$10$e20LiJnAVtrpI8w3HSgT6e..6ikDXx0bHGM5L0ERDytCwSspYVbFi'),
(30, 'test.test@test.fr', 'test', 'test', '$2y$10$CWDMHHCgzg2KE8dv2ozBdO0bbtKKhU4vaxQlKD5VE6yylKEes4GZm');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `picture_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

--
-- Contraintes pour la table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
