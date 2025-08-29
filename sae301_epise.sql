-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 06 juil. 2025 à 09:40
-- Version du serveur : 8.0.31
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sae301_epise`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(191) NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `login`, `mdp`) VALUES
(2, 'admin', '$2y$10$MArJUbaJZvCTcbGzK7yDfO88vLIJOT31bWGacPWjmkfabh90b5QtW');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text,
  `slug` varchar(40) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_publication` date NOT NULL,
  `is_main` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_article`, `titre`, `contenu`, `slug`, `image`, `date_publication`, `is_main`) VALUES
(1, 'Ouverture de l\'EPISE', 'L\'épise est ouverte ce jeudi 03/07 ! De 13h30 à 15h00.', 'ouverture_epise', 'ouvert.jpg', '2025-07-05', 1),
(2, 'Dons alimentaires', 'Merci aux étudiants de MMI pour leurs dons alimentaires !\r\n', 'dons_mmi', 'dons.jpg', '2025-07-05', 0),
(3, 'Arrivages du vendredi 21/06', 'Nouveaux arrivages ce vendredi 21/06 !\r\n', 'arrivage_21_Juin', 'donsaliments.webp', '2025-07-05', 0),
(5, 'Ouverture 12/06', 'Ouverture de l\'EPISE ce mercredi 12/06 toute la matinée !\r\n', 'ouverture_12_juin', 'ouverture.jpg', '2025-07-05', 0);

-- --------------------------------------------------------

--
-- Structure de la table `benevoles`
--

DROP TABLE IF EXISTS `benevoles`;
CREATE TABLE IF NOT EXISTS `benevoles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `valide` tinyint(1) DEFAULT '0',
  `date_demande` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_validation` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `benevoles`
--

INSERT INTO `benevoles` (`id`, `nom`, `prenom`, `email`, `telephone`, `valide`, `date_demande`, `date_validation`) VALUES
(2, 'Nuit', 'Nuit', 'nuit@mail.com', '854960', 1, '2025-07-02 11:40:42', '2025-07-02 14:56:16'),
(3, 'Mardi', 'Mardi', 'mardi@mail.com', '857960', 0, '2025-07-02 11:41:33', '0000-00-00 00:00:00'),
(4, 'Mercredi', 'Mercredi', 'mercredi@mail.com', '867960', 0, '2025-07-02 11:41:33', NULL),
(10, 'AMIN HANDOYO', 'Camélia', 'camhdyo@gmail.com', '998696', 0, '2025-07-06 17:11:03', NULL),
(11, 'AMIN HANDOYO', 'Camélia', 'camhdyo@gmail.com', '998696', 0, '2025-07-06 17:14:55', NULL),
(12, 'lili', 'lala', 'lolo@gmail.com', '887766', 0, '2025-07-06 17:15:14', NULL),
(13, 'lili', 'lolo', 'lulu@gmail.com', '778866', 0, '2025-07-06 17:21:15', NULL),
(14, 'llolo', 'ljk', 'lkj@gmail.com', '1234567', 0, '2025-07-06 17:23:39', NULL),
(15, 'AMIN HANDOYO', 'Camélia', 'camhdyo@gmail.com', '998696', 0, '2025-07-06 17:34:36', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `carrousel`
--

DROP TABLE IF EXISTS `carrousel`;
CREATE TABLE IF NOT EXISTS `carrousel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `categorie` varchar(50) NOT NULL DEFAULT 'accueil',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `carrousel`
--

INSERT INTO `carrousel` (`id`, `titre`, `image`, `description`, `categorie`) VALUES
(14, 'UNC', 'unc.jpg', 'Partenaire UNC', 'partenaires'),
(16, 'Shell', 'Shell.png', 'Partenaire Shell', 'partenaires'),
(18, 'MDE', 'mde.png', 'Partenaire MDE', 'partenaires'),
(19, 'Province Sud', 'logo-province-sud-nc.png', 'Partenaire Province Sud', 'partenaires'),
(20, 'GF', 'gf.jpg', 'Partenaire GF', 'partenaires');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Snacks & biscuits'),
(2, 'Vêtements'),
(3, 'Produits hygiéniques'),
(4, 'Produits bébé'),
(5, 'Fruits & légumes'),
(6, 'Boissons'),
(10, 'Conserves & bocaux');

-- --------------------------------------------------------

--
-- Structure de la table `dons`
--

DROP TABLE IF EXISTS `dons`;
CREATE TABLE IF NOT EXISTS `dons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `categorie_id` int NOT NULL,
  `produit` varchar(255) NOT NULL,
  `quantite` int NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `date_disponible` date NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `date_don` datetime NOT NULL,
  `valide` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `categorie_id` (`categorie_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dons`
--

INSERT INTO `dons` (`id`, `user_id`, `categorie_id`, `produit`, `quantite`, `photo`, `date_disponible`, `lieu`, `date_don`, `valide`) VALUES
(5, 23, 1, 'Pommes', 50, NULL, '0000-00-00', '', '2025-06-27 03:54:22', 1),
(6, 24, 3, 'Gel douche', 5, NULL, '0000-00-00', '', '2025-06-27 05:22:47', 0),
(7, 24, 1, 'Pommes', 50, NULL, '0000-00-00', '', '2025-06-27 05:27:58', 0),
(13, 24, 1, 'Boîte de viande', 5, NULL, '0000-00-00', '', '2025-06-27 05:47:25', 0),
(14, 26, 1, 'Nutella', 100, NULL, '0000-00-00', '', '2025-06-29 21:52:21', 0),
(15, 27, 1, 'Nutella', 5, NULL, '0000-00-00', '', '2025-07-01 00:48:43', 0),
(16, 27, 1, 'Pommes', 50, NULL, '0000-00-00', '', '2025-07-01 00:53:36', 0),
(17, 27, 2, 'Sac', 2, NULL, '0000-00-00', '', '2025-07-01 00:53:59', 0),
(18, 29, 1, 'Bonbons Dragibus', 12, NULL, '0000-00-00', '', '2025-07-06 05:26:25', 0),
(19, 29, 1, 'Bonbons Dragibus', 12, NULL, '0000-00-00', '', '2025-07-06 05:32:58', 0),
(20, 29, 1, 'Bonbons Dragibus', 12, NULL, '0000-00-00', '', '2025-07-06 05:33:18', 0),
(21, 29, 1, 'Bonbons Dragibus', 12, NULL, '0000-00-00', '', '2025-07-06 05:34:33', 0),
(22, 29, 1, 'Bonbons Dragibus', 12, NULL, '0000-00-00', '', '2025-07-06 05:34:39', 0),
(23, 29, 1, 'Bonbons Dragibus', 12, NULL, '0000-00-00', '', '2025-07-06 05:35:15', 0),
(24, 29, 1, 'Bonbons Dragibus', 12, NULL, '0000-00-00', '', '2025-07-06 05:47:11', 0),
(25, 29, 1, 'Bonbons Dragibus', 12, NULL, '0000-00-00', '', '2025-07-06 05:47:45', 0);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `stock` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `name`, `description`, `stock`, `image`, `category_id`) VALUES
(8, 'Purée de pomme de terre', 'Purée Mousline Maggi', 6, 'images/mousline.jpg', 10),
(16, 'Sac à dos', 'Sac à dos Eastpack noir', 0, 'images/eastpack_noir.jpg', 2),
(17, 'Gel douche', 'Gel douche Ushuaïa Polynésie', 20, 'images/gel_douche_polynesie.jpg', 3),
(18, 'Boîte de viande', 'Conserve de viande', 18, 'images/boite_viande.jpg', 1),
(19, 'Pommes', 'Pommes Gala fraîches', 441, 'images/pommes.png', 1),
(21, 'Casquette', 'Casquette basique bleu', 2, 'images/casquette_bleu.jpg', 2),
(22, 'Gel douche', 'Gel douche Corine de Farme', 20, 'images/gel_douche_corine.jpg', 3),
(23, 'Pâtes spagetti', 'Pâtes Panzani spagetti', 100, 'images/pâtes.jpeg', 10),
(24, 'Riz', 'Riz thaï jasmin', 40, 'images/riz.png', 10),
(26, 'Jus d\'orange', 'Jus d\'orange pur jus', 50, 'images/jus_orange.png', 1),
(27, 'Compotes', 'Compotes de pommes Andros', 70, 'images/compote.jpg', 1),
(28, 'Chaussure en toile', 'Chaussures en toiles bleues', 2, 'images/chaussure_toile.webp', 2),
(40, 'Dentifrice', 'Dentifrice Signal blancheur', 15, 'images/dentifrice.avif', 3),
(41, 'Brosse à dents', 'Brosses à dents Signal', 4, 'images/brosse_dent.webp', 3),
(42, 'Paté jambon', 'Délice de jambon Tulip', 22, 'images/pate_jambon.jpg', 10),
(43, 'Pâtes macaroni', 'Pâtes Panzani macaroni', 10, 'images/panzani_macaroni.jpg', 10),
(44, 'Eau fruits rouges', 'Eau Volvic fruits rouges', 6, 'images/volvic_fruit_rouge.jpg', 6),
(45, 'Pepsi Zero', 'Pepsi Zero 1,5L', 6, 'images/pepsi_zero.webp', 6),
(46, 'Coca-Cola', 'Coca-Cola 1,5L', 10, 'images/coca.jpg', 6),
(47, 'Compotes pour bébé', 'Compotes Blédina pommes bannanes', 4, 'images/compote_bebe.jpg', 4),
(48, 'Couches', 'Couches bébé Ultra dry', 5, 'images/couches_dry.jpg', 4),
(49, 'Déodorant', 'Déodorant Dove advanced care', 7, 'images/deo_dove.jpg', 3),
(50, 'Déodorant', 'Déodorant Nivea Men Fresh', 4, 'images/deo_nivea_fresh.jpeg', 3),
(51, 'Dentifrice', 'Dentifrice Aquafresh blancheur', 6, 'images/dentifrice_aquafresh.jpg', 3),
(52, 'Après shampoing', 'Après shampoing Garnier Richesse d\'Argan', 7, 'images/apres_shampoing_garnier_argan.jpg', 3),
(53, 'Après shampoing', 'Après shampoing Garnier Huiles Merveilleuses', 6, 'images/apres_shampoing_garnier_karite.jpg', 3),
(54, 'Shampoing', 'Shampoing Palmolive pomme', 0, 'images/shampoing_palmolive_apple.jpg', 3),
(55, 'Savon', 'Savon Palmolive citrus & cream', 20, 'images/savon_palmolive_citrus.jpg', 3),
(56, 'Gâteaux Cookies ', 'Cookies Granolas gros éclats de chocolat', 5, 'images/granola_cookies.jpg', 1),
(57, 'Chips Twisties ', 'Chips Twisties Poulet', 6, 'images/twisties_poulet.jpg', 1),
(58, 'Carottes', 'Carottes vrac', 7, 'images/carotte.jpg', 5),
(59, 'Tomates', 'Tomates vrac', 7, 'images/tomate.webp', 5);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` datetime NOT NULL,
  `statut` varchar(20) DEFAULT 'en_attente',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `date`, `statut`) VALUES
(1, 29, '2025-07-06 04:39:04', 'en_attente'),
(2, 29, '2025-07-06 04:58:41', 'validee');

-- --------------------------------------------------------

--
-- Structure de la table `reservation_produits`
--

DROP TABLE IF EXISTS `reservation_produits`;
CREATE TABLE IF NOT EXISTS `reservation_produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reservation_id` int NOT NULL,
  `produit_id` int NOT NULL,
  `quantite` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reservation_id` (`reservation_id`),
  KEY `produit_id` (`produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservation_produits`
--

INSERT INTO `reservation_produits` (`id`, `reservation_id`, `produit_id`, `quantite`) VALUES
(1, 1, 8, 5),
(2, 2, 19, 2),
(3, 2, 18, 2),
(4, 2, 21, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_etudiant` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `adherent` tinyint(1) NOT NULL DEFAULT '0',
  `role` varchar(20) DEFAULT 'particulier',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `numero_etudiant`, `prenom`, `nom`, `email`, `password`, `adherent`, `role`) VALUES
(13, '12345', 'Camélia', 'AMIN HANDOYO', 'camhdyo@gmail.com', '$2y$10$xd4gjB0F22M0UAVXY1W8pukHL3GJUt8cbMG5uvNMXCjpWRKYgrjDS', 0, 'etudiant'),
(15, '65431', 'ai', 'AMIN HANDOYO', 'lolo@gmail.com', '$2y$10$SODzj.i2l2rwFYtMXq9N6uNGTS514O3WgEn2Fyeb0HMUX1vpZTb.a', 0, 'etudiant'),
(16, '09876', 'papa', 'loulou', 'popo@gmail.com', '$2y$10$kFCO2m/QYyFYC0gdiBjji.LP8PoZCYwvzl3ONmeuHouiyXL.qsH5m', 0, 'etudiant'),
(17, '56789', 'PIPI', 'KAKA', 'KAKA@gmail.com', '$2y$10$1HpWzPdgF4jUog5TnzgssOmGFTycsELPNsyE.58jFYiRHI3oaBcXW', 1, 'etudiant'),
(18, '09876', 'lala', 'lolo', 'lili@gmail.com', '$2y$10$yeCfx.37BIwExMERVlRYZ.V9i63XXCV..s9KyAbyjmjFHl1hUXlZq', 1, 'etudiant'),
(19, '4567', 'ondine', 'Taukolo', 'ondine@gmail.com', '$2y$10$fe8/4U8smRtfeNLhWO.Cp.4mstvlIWgRIycnf0lXA0ffxghMlWVui', 1, 'etudiant'),
(20, NULL, 'keniuin', 'Carrefour', 'lkjh@gmail.com', '$2y$10$BKLxDMf.dpHDKCW5An.EoOD7EhDU0orVWEs8NOJSKX38eYQg29tGq', 0, 'particulier'),
(21, '25900', 'Kitsu', 'Kitsu', 'kitsu@mail.com', '$2y$10$rOV6lxuRtYvQNQkjhsKfDeDVLTertcQ6gjbGzTTvGAgVJ9EX5TYr6', 1, 'etudiant'),
(22, '30600', 'Kitsuny', 'Kitsuny', 'kitsuny@mail.com', '$2y$10$wt3lt2vI7NF1wEQ4x4SdCuWlaa.xM398BNMiHGZLsLorh2z4XobjO', 1, 'etudiant'),
(23, NULL, 'ticulier', 'Par', 'par@mail.com', '$2y$10$9Z9iUbCZPoMfas7KCsIFzuAU7O9IGlBFswhej2z5rsOU3Q6.x6ahC', 0, 'particulier'),
(24, NULL, 'dredi', 'ven', 'vendredi@mail.com', '$2y$10$yrzMVIlZQv7mlPZJ3D9NAubhNQS8Z/OGBmkCZvCpuURDRFdYczwqi', 0, 'particulier'),
(26, NULL, 'Culier', 'Par', 'particulier@mail.com', '$2y$10$MHzScylmXt1/M/9ag9Vhy.MYH2SeRAkE.MbwamjFTbYI4Pmwkyph2', 0, 'particulier'),
(27, NULL, 'Mardi', 'Mar', 'mardi@mail.com', '$2y$10$o7mdjNRKBVKhLd9aQupV7uf3/RpkjaAqH3NuwXRmNsThZo4sTO4ki', 0, 'particulier'),
(28, '25500', 'Mer', 'Credi', 'mercredi@mail.com', '$2y$10$KpP8s6E2WKp7KkPm/M4SeeN6vPwdt4v/QbJgYCGtaBI1sdrOe.LYe', 1, 'etudiant'),
(29, '3456', 'liz', 'am', 'liz@gmail.com', '$2y$10$klgglNNPGtcF6.rHZdtnm.IFX.bx.GG5BiN2r.D9GA2aXG651jOLu', 1, 'etudiant');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `dons`
--
ALTER TABLE `dons`
  ADD CONSTRAINT `dons_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `dons_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `reservation_produits`
--
ALTER TABLE `reservation_produits`
  ADD CONSTRAINT `reservation_produits_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`),
  ADD CONSTRAINT `reservation_produits_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
