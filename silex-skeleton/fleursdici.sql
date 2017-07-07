-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 07 juil. 2017 à 18:09
-- Version du serveur :  10.1.22-MariaDB
-- Version de PHP :  7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `fleursdici`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(10) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `short_content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(250) NOT NULL,
  `id_category` int(10) NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `short_content`, `picture`, `id_category`) VALUES
(2, '', '', '', '', 0),
(3, 'Les fleurs d\'ici présente leur nouveau site lol', 'tyut', 'ytyutyu', 'back.jpg', 0),
(4, 'Les fleurs d\'ici présente leur nouveau site lol', 'fkjgokgjklhjgfkhjgfklhjgf!hgjghkfjhgfkfkhjgklhjgfhj', 'g,hgfkj', 'picto-Le-Power-to-Gas.png', 3),
(101, 'yrtrty', 'rtytyty', 'tyrty', '', 0),
(102, 'hjhk', 'kkj', 'hhjhj', '', 0),
(103, '', '', '', '', 0),
(104, '', '', '', '', 0),
(105, 'gfhfh', 'ghfhg', 'fhf', '2.jpg', 0);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `category_name` enum('article','lexiquedefleurs','conseilpratique') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(1, 'article'),
(2, 'conseilpratique'),
(3, 'lexiquedefleurs'),
(4, 'article'),
(5, ''),
(6, '');

-- --------------------------------------------------------

--
-- Structure de la table `gift`
--

CREATE TABLE `gift` (
  `id_gift` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_receiver` int(5) NOT NULL,
  `id_product` int(1) NOT NULL,
  `id_shipping` int(1) NOT NULL,
  `duration` int(1) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_price` int(3) NOT NULL,
  `code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `gift`
--

INSERT INTO `gift` (`id_gift`, `id_user`, `id_receiver`, `id_product`, `id_shipping`, `duration`, `start_date`, `end_date`, `total_price`, `code`) VALUES
(1, 11, 0, 3, 2, 6, '0000-00-00', '0000-00-00', 0, ''),
(2, 11, 0, 2, 1, 3, NULL, NULL, 180, ''),
(3, 11, 0, 4, 2, 3, NULL, NULL, 210, '3EFE8FK2LNHMS4OW4SA7');

-- --------------------------------------------------------

--
-- Structure de la table `pickuplocation`
--

CREATE TABLE `pickuplocation` (
  `id_pul` int(5) NOT NULL,
  `name_pul` varchar(50) NOT NULL,
  `address_pul` text NOT NULL,
  `zipcode_pul` int(5) NOT NULL,
  `city_pul` varchar(20) NOT NULL,
  `phone_pul` int(10) NOT NULL,
  `hours` text NOT NULL,
  `googlemaps_location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `pickuplocation`
--

INSERT INTO `pickuplocation` (`id_pul`, `name_pul`, `address_pul`, `zipcode_pul`, `city_pul`, `phone_pul`, `hours`, `googlemaps_location`) VALUES
(3, 'Boutique Bis', '10 rue boulevard du Temple', 75003, 'Paris', 144781108, 'lundi\r\n10:00–19:30\r\nmardi\r\n10:00–19:30\r\nmercredi\r\n10:00–19:30\r\njeudi\r\n10:00–19:30\r\nvendredi\r\n10:00–19:30\r\nsamedi\r\n10:00–19:30\r\ndimanche\r\nFermé', '48.863676, 2.366254'),
(4, 'A nous Paris', '19 rue Clauzel', 75009, 'Paris', 142799904, 'lundi\r\nFermé\r\nmardi\r\nFermé\r\nmercredi\r\n10:00–19:00\r\njeudi\r\n10:00–19:00\r\nvendredi\r\n10:00–19:00\r\nsamedi\r\n11:00–19:00\r\ndimanche\r\nFermé', '48.879365, 2.338008'),
(8, 'Jawn Black', '182 avenue Denfert Rochereau', 75014, 'Paris', 123456789, 'fggf', 'fgfgf');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id_product` int(5) NOT NULL,
  `product_name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `price` int(100) NOT NULL,
  `size` enum('moyen','gros') NOT NULL,
  `frequency` enum('once_a_month','twice_a_month') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id_product`, `product_name`, `description`, `photo`, `price`, `size`, `frequency`) VALUES
(1, 'Amarande', 'Une brassée de fleurs par mois pour décorer votre maison.', 'photo1.jpg', 30, 'moyen', 'once_a_month'),
(2, 'Hanaé', 'Une brassée de fleurs deux fois par mois pour illuminer votre maison.', 'photo2.jpg', 55, 'moyen', 'twice_a_month'),
(3, 'Marjolaine', 'Une grande brassée de fleurs de saison une fois par mois pour votre maison.', 'photo3.jpg', 40, 'gros', 'once_a_month'),
(4, 'Vardan', 'Une grande brassée de fleurs deux fois par mois. ', 'photo4.jpg', 70, 'gros', 'twice_a_month');

-- --------------------------------------------------------

--
-- Structure de la table `shipping`
--

CREATE TABLE `shipping` (
  `id_shipping` int(5) NOT NULL,
  `mode` enum('domicile','point_relais') NOT NULL,
  `shipping_fees` decimal(65,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `shipping`
--

INSERT INTO `shipping` (`id_shipping`, `mode`, `shipping_fees`) VALUES
(1, 'domicile', '5'),
(2, 'point_relais', '0');

-- --------------------------------------------------------

--
-- Structure de la table `subscription`
--

CREATE TABLE `subscription` (
  `id_subscription` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_product` int(2) NOT NULL,
  `id_shipping` int(5) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `subscription`
--

INSERT INTO `subscription` (`id_subscription`, `id_user`, `id_product`, `id_shipping`, `start_date`, `end_date`, `soft_delete`) VALUES
(1, 10, 1, 1, '2017-06-01', '0000-00-00', 0),
(2, 11, 2, 1, '2017-06-01', NULL, 1),
(3, 2, 2, 2, '0000-00-00', NULL, 1),
(4, 14, 3, 2, '0000-00-00', NULL, 1),
(5, 15, 3, 2, '0000-00-00', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(5) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `address` text,
  `zipcode` int(5) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `status` enum('admin','collaborator','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `lastname`, `firstname`, `address`, `zipcode`, `city`, `phone`, `status`) VALUES
(2, 'radio-nova@hotmail.fr', '$2y$10$amu4YyllkMxL2P0uVpgOyOYMFyW.kTysCd5nO49mj3F3CxoMMUIb6', 'louis', 'loli', NULL, NULL, NULL, '689560205', ''),
(5, 'gerard@email.fr', '$2y$10$brt/rR/GVSFr9GRinugIQ..8dpUdiaNoJKNuv7jeVGx8CjoGzfJJ.', 'Dupont', 'Gérard', '3 rue du pavillon bleu', 75012, 'Paris', '123456789', 'user'),
(6, 'maurice@email.fr', '$2y$10$4Y8k6LJvXbGvHBjvNKUXTe9uKLDxbnURtl3ZnFvVY61bq5rxnD0YS', 'Dupuis', 'Maurice', NULL, NULL, NULL, '0612345678', 'user'),
(10, 'jawn@hotmail.fr', '$2y$10$B0eCe9KlQz/Ri9E8FwZCQe6Jw8..ag2xWLDZzBeEJi287QbYO3wZW', 'Black', 'Jawn', '3 rue des paquerettes', 75014, 'Paris', '123456789', 'admin'),
(11, 'admin@email.fr', '$2y$10$fl0h4yn.Nksi0zM1u/Y8YeS5HiKCOSbFPTwX5RnofWz4VLu4Ru2TG', 'admin_lastname', 'admin_firstname', 'rue des admins', 75014, 'Paris', '0612345678', 'admin'),
(12, 'morganelydia@hotmail.com', '$2y$10$j92RowTXK/Ftw8LytJ3OTuw3ckNzN5NU3JBxEnTaUoMe32o1BQecq', 'Roulland', 'Morgane', 'dfsfd', 75014, 'Par', '1234567890', 'user'),
(13, 'hermione@email.fr', '$2y$10$w.Tg5ik.PpZolvqKOgkyNOdD20NhnvinCNOoI5GdLTL/13Ulm/5Gu', 'Granger', 'Hermione', 'Salle commune de Gryffondor', 12345, 'Poudlard', '1234567890', 'user'),
(14, 'tanguy.pichavant@hotmail.com', '$2y$10$w3OJrSUaBvWOMWPL2curT.GUVRuEGW2xLBPEM213w36M3z6LzXeRa', 'pichavant', 'tanguy', 'fgjdfgjfdg', 75019, 'paris', '0678560452', 'user'),
(15, 'tanguy.pichavant@gmail.com', '$2y$10$AQx1bg/nA372xKFHLicLO.T85JLzZ01uozUkMmfS6LgJILgSiAT42', 'pich', 'tang', '159 rue', 75019, 'paris', '0678560452', ''),
(16, 'ertrer@hotmail.com', '$2y$10$NotA.qXt/TVyCEOnZTfAL.WwpufC4a9a.EMg6RSuzu4h.aPYI9uYi', 'pichavant', 'tanguy', '12 rthrtyuytjtyjt', 75019, 'paris', '6785604525', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`id_category`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `gift`
--
ALTER TABLE `gift`
  ADD PRIMARY KEY (`id_gift`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_receiver` (`id_receiver`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_shipping` (`id_shipping`);

--
-- Index pour la table `pickuplocation`
--
ALTER TABLE `pickuplocation`
  ADD PRIMARY KEY (`id_pul`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Index pour la table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id_shipping`);

--
-- Index pour la table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id_subscription`),
  ADD KEY `id_personne` (`id_user`),
  ADD KEY `id_produit` (`id_product`),
  ADD KEY `id_livraison` (`id_shipping`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `gift`
--
ALTER TABLE `gift`
  MODIFY `id_gift` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `pickuplocation`
--
ALTER TABLE `pickuplocation`
  MODIFY `id_pul` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id_shipping` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id_subscription` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
